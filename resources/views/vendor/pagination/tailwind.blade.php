@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-surface-500">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-semibold text-surface-700">{{ $paginator->firstItem() }}</span>
                        -
                        <span class="font-semibold text-surface-700">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari
                    <span class="font-semibold text-surface-700">{{ $paginator->total() }}</span>
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-xl shadow-sm ring-1 ring-surface-200">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center rounded-l-xl border-r border-surface-200 bg-white px-3 py-2 text-sm font-medium text-surface-300" aria-hidden="true">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}"
                            class="relative inline-flex items-center rounded-l-xl border-r border-surface-200 bg-white px-3 py-2 text-sm font-medium text-surface-600 transition-colors hover:bg-primary-50 hover:text-primary-700">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-surface-400">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="relative inline-flex items-center bg-ink px-4 py-2 font-mono text-sm font-medium tabular-nums text-paper">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                        class="relative inline-flex items-center border-l border-surface-200 bg-white px-4 py-2 text-sm font-medium text-surface-600 transition-colors hover:bg-primary-50 hover:text-primary-700">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}"
                            class="relative inline-flex items-center rounded-r-xl border-l border-surface-200 bg-white px-3 py-2 text-sm font-medium text-surface-600 transition-colors hover:bg-primary-50 hover:text-primary-700">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center rounded-r-xl border-l border-surface-200 bg-white px-3 py-2 text-sm font-medium text-surface-300" aria-hidden="true">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif