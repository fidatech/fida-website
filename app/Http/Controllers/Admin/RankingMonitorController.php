<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RankingTarget;
use App\Models\SearchConsoleMetric;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RankingMonitorController extends Controller
{
    public function index(): View
    {
        $periods = SearchConsoleMetric::query()
            ->select('period_start', 'period_end')
            ->distinct()
            ->orderByDesc('period_end')
            ->limit(2)
            ->get();

        $latest = $periods->get(0);
        $previous = $periods->get(1);

        $targets = RankingTarget::query()->orderByDesc('active')->orderBy('keyword')->get();

        $rows = $targets->map(function (RankingTarget $target) use ($latest, $previous): array {
            $latestMetric = $latest
                ? SearchConsoleMetric::query()
                    ->where('metric_type', 'query')
                    ->where('period_start', $latest->period_start)
                    ->where('period_end', $latest->period_end)
                    ->whereRaw('LOWER(dimension) = ?', [mb_strtolower($target->keyword)])
                    ->first()
                : null;

            $previousMetric = $previous
                ? SearchConsoleMetric::query()
                    ->where('metric_type', 'query')
                    ->where('period_start', $previous->period_start)
                    ->where('period_end', $previous->period_end)
                    ->whereRaw('LOWER(dimension) = ?', [mb_strtolower($target->keyword)])
                    ->first()
                : null;

            $position = $latestMetric?->position !== null ? (float) $latestMetric->position : null;
            $previousPosition = $previousMetric?->position !== null ? (float) $previousMetric->position : null;

            return [
                'target' => $target,
                'latest' => $latestMetric,
                'previous' => $previousMetric,
                'position_delta' => ($position !== null && $previousPosition !== null)
                    ? round($previousPosition - $position, 2)
                    : null,
                'gap_to_target' => $position !== null
                    ? round($position - (float) $target->target_position, 2)
                    : null,
            ];
        });

        $opportunities = SearchConsoleMetric::query()
            ->when($latest, fn ($query) => $query
                ->where('period_start', $latest->period_start)
                ->where('period_end', $latest->period_end))
            ->where('metric_type', 'query')
            ->where('impressions', '>=', 5)
            ->whereBetween('position', [3, 25])
            ->orderByDesc('impressions')
            ->limit(100)
            ->get();

        return view('admin.rankings.index', compact('rows', 'opportunities', 'latest', 'previous'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'keyword' => ['required', 'string', 'max:255'],
            'locale' => ['required', 'in:en,fa,ps'],
            'target_url' => ['nullable', 'string', 'max:512'],
            'target_position' => ['required', 'numeric', 'between:1,100'],
            'notes' => ['nullable', 'string', 'max:3000'],
        ]);

        RankingTarget::query()->updateOrCreate(
            ['keyword' => trim($validated['keyword']), 'locale' => $validated['locale']],
            [
                'target_url' => $validated['target_url'] ?? null,
                'target_position' => $validated['target_position'],
                'notes' => $validated['notes'] ?? null,
                'active' => true,
            ],
        );

        return back()->with('success', 'Ranking target saved.');
    }

    public function update(Request $request, RankingTarget $rankingTarget): RedirectResponse
    {
        $validated = $request->validate([
            'target_url' => ['nullable', 'string', 'max:512'],
            'target_position' => ['required', 'numeric', 'between:1,100'],
            'active' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:3000'],
        ]);

        $rankingTarget->update([
            ...$validated,
            'active' => $request->boolean('active'),
        ]);

        return back()->with('success', 'Ranking target updated.');
    }

    public function destroy(RankingTarget $rankingTarget): RedirectResponse
    {
        $rankingTarget->delete();

        return back()->with('success', 'Ranking target removed.');
    }
}
