@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Halaman">
        @if ($paginator->onFirstPage())
            <span class="disabled">&lsaquo; Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">&lsaquo; Sebelumnya</a>
        @endif

        <span class="info">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Berikutnya &rsaquo;</a>
        @else
            <span class="disabled">Berikutnya &rsaquo;</span>
        @endif
    </nav>
@endif
