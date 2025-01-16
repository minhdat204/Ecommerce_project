@if ($paginator->lastPage() > 1)
    <div class="product__pagination">
        @if ($paginator->currentPage() > 1)
            <a href="{{ $paginator->appends(request()->except('page'))->previousPageUrl() }}">
                <i class="fa fa-long-arrow-left"></i>
            </a>
        @endif

        @php
            $start = max($paginator->currentPage() - 2, 1);
            $end = min($start + 4, $paginator->lastPage());
            $start = max(min($start, $paginator->lastPage() - 4), 1);
        @endphp

        @if ($start > 1)
            <a href="{{ $paginator->appends(request()->except('page'))->url(1) }}">1</a>
            @if ($start > 2)
                <span>...</span>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            <a href="{{ $paginator->appends(request()->except('page'))->url($i) }}"
                class="{{ $paginator->currentPage() == $i ? 'active' : '' }}">
                {{ $i }}
            </a>
        @endfor

        @if ($end < $paginator->lastPage())
            @if ($end < $paginator->lastPage() - 1)
                <span>...</span>
            @endif
            <a href="{{ $paginator->appends(request()->except('page'))->url($paginator->lastPage()) }}">
                {{ $paginator->lastPage() }}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->appends(request()->except('page'))->nextPageUrl() }}">
                <i class="fa fa-long-arrow-right"></i>
            </a>
        @endif
    </div>
@endif
