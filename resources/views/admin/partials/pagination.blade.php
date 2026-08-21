@if($paginator->hasPages())
    <nav class="console-pagination" aria-label="Pagination">
        <span>Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}</span>
        <div>
            @if($paginator->onFirstPage())<span class="disabled">← Previous</span>@else<a href="{{ $paginator->previousPageUrl() }}">← Previous</a>@endif
            <b>{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</b>
            @if($paginator->hasMorePages())<a href="{{ $paginator->nextPageUrl() }}">Next →</a>@else<span class="disabled">Next →</span>@endif
        </div>
    </nav>
@endif
