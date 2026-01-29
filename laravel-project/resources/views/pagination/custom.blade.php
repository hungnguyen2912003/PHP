@if ($paginator->hasPages())
    <nav aria-label="Page navigation example" class="custom-pagination">
        <ul class="pagination mb-0 justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <button class="page-link icon" aria-hidden="true">
                        <i class="material-symbols-outlined">west</i>
                    </button>
                </li>
            @else
                <li class="page-item">
                    <button type="button" class="page-link icon" onclick="window.location.href='{{ $paginator->previousPageUrl() }}'" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="material-symbols-outlined">west</i>
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><button class="page-link active">{{ $page }}</button></li>
                        @else
                            <li class="page-item"><button type="button" class="page-link" onclick="window.location.href='{{ $url }}'">{{ $page }}</button></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button type="button" class="page-link icon" onclick="window.location.href='{{ $paginator->nextPageUrl() }}'" rel="next" aria-label="@lang('pagination.next')">
                        <i class="material-symbols-outlined">east</i>
                    </button>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <button class="page-link icon" aria-hidden="true">
                        <i class="material-symbols-outlined">east</i>
                    </button>
                </li>
            @endif
        </ul>
    </nav>
@endif
