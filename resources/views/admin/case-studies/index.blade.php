@extends('layouts.admin')

@section('title', 'Case Studies')
@section('eyebrow', 'Growth / proof & authority')

@section('content')
<section class="editor-heading">
    <div><small class="section-code">VERIFIED IMPLEMENTATION EVIDENCE</small><h1>Case study studio</h1><p>Create manually with the rich editor or answer a guided interview and let the AI prepare an English/Dari/Pashto draft.</p></div>
    <div class="editor-actions"><a class="console-button console-button-quiet" href="{{ route('admin.content-pages.create',['type'=>'case-study']) }}">Manual case study</a><a class="console-button console-button-primary" href="{{ route('admin.case-studies.create') }}">Guided draft ↗</a></div>
</section>
<section class="console-card table-card"><header><div><small>Publication pipeline</small><h2>Case studies</h2></div></header><div class="analytics-table-wrap"><table data-datatable><thead><tr><th data-sort>Case study</th><th data-sort>Status</th><th data-sort>Updated</th><th></th></tr></thead><tbody>
@forelse($caseStudies as $page)<tr><td><strong>{{ $page->translation('title','en') }}</strong><small>/{{ $page->slug }}</small></td><td>{{ strtoupper($page->status) }}</td><td data-value="{{ $page->updated_at->timestamp }}">{{ $page->updated_at->diffForHumans() }}</td><td><a href="{{ route('admin.content-pages.edit',$page) }}">Review ↗</a></td></tr>@empty<tr><td colspan="4">No case studies yet.</td></tr>@endforelse
</tbody></table></div><div class="admin-card-pad">{{ $caseStudies->links() }}</div></section>
@endsection
