@if ($paginator->hasPages())
<div class="flex-wr-c-c m-rl--7 p-t-15">
  {{-- Previous Page Link --}}
  @if ($paginator->onFirstPage())
    {{-- <a href="#" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 disabled" aria-disabled="true" aria-label="@lang('pagination.previous')"><<</a> --}}
  @else
    <a href="{{ $paginator->previousPageUrl() }}" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7" rel="prev" aria-label="@lang('pagination.previous')"><<</a>
  @endif

  {{-- Pagination Elements --}}
  @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
      <a href="#" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 disabled">{{ $element }}</a>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
          <a href="#" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 pagi-active">{{ $page }}</a>
        @else
          <a href="{{ $url }}" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7">{{ $page }}</a>
        @endif
      @endforeach
    @endif
  @endforeach

  {{-- Next Page Link --}}
  @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7"  rel="next" aria-label="@lang('pagination.next')">>></a>
  @else
    {{-- <a href="#" class="flex-c-c pagi-item hov-btn1 trans-03 m-all-7 disabled" aria-disabled="true" aria-label="@lang('pagination.next')">>></a> --}}
  @endif
</div>
@endif