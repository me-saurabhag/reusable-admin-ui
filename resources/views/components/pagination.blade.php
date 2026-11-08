@props(['paginator', 'showSummary' => true, 'maxPages' => 5])
@if($paginator && $paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $half = (int) floor(max(1, $maxPages) / 2);
        $start = max(1, $current - $half);
        $end = min($last, $start + max(1, $maxPages) - 1);
        $start = max(1, $end - max(1, $maxPages) + 1);
    @endphp
    <nav {{ $attributes->class('rai-pagination') }} aria-label="Pagination">
        @if($showSummary)
            <div class="rai-pagination__summary">
                Showing <strong>{{ $paginator->firstItem() ?? 0 }}</strong>–<strong>{{ $paginator->lastItem() ?? 0 }}</strong>
                of <strong>{{ $paginator->total() }}</strong>
            </div>
        @endif
        <div class="rai-pagination__controls">
            @if($paginator->onFirstPage())
                <span class="rai-pagination__control is-disabled" aria-disabled="true">Previous</span>
            @else
                <a class="rai-pagination__control" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
            @endif
            @if($start > 1)
                <a class="rai-pagination__page" href="{{ $paginator->url(1) }}">1</a>
                @if($start > 2)<span class="rai-pagination__ellipsis">…</span>@endif
            @endif
            @for($page = $start; $page <= $end; $page++)
                @if($page === $current)
                    <span class="rai-pagination__page is-active" aria-current="page">{{ $page }}</span>
                @else
                    <a class="rai-pagination__page" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                @endif
            @endfor
            @if($end < $last)
                @if($end < $last - 1)<span class="rai-pagination__ellipsis">…</span>@endif
                <a class="rai-pagination__page" href="{{ $paginator->url($last) }}">{{ $last }}</a>
            @endif
            @if($paginator->hasMorePages())
                <a class="rai-pagination__control" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
            @else
                <span class="rai-pagination__control is-disabled" aria-disabled="true">Next</span>
            @endif
        </div>
    </nav>
@endif
