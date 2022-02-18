@if ($paginator['paginator']->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator['paginator']->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $uri . $paginator['paginator']->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator['paginator']->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $uri . $paginator['paginator']->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
