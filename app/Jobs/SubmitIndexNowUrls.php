<?php

namespace App\Jobs;

use App\Support\IndexNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class SubmitIndexNowUrls implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public function __construct(public array $urls)
    {
        $this->onConnection('sync');
    }

    public function handle(IndexNow $indexNow): void
    {
        if (! config('website.indexable') || blank(config('website.indexnow.key'))) {
            return;
        }

        try {
            $indexNow->submit($this->urls);
        } catch (Throwable $exception) {
            Log::warning('Automatic IndexNow submission failed.', [
                'message' => $exception->getMessage(),
                'urls' => $this->urls,
            ]);
        }
    }
}
