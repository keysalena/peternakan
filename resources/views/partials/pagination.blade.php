@if ($paginator->hasPages())
<div class="pager">
  <a class="chip" href="{{ $paginator->previousPageUrl() ?? '#' }}" aria-disabled="{{ $paginator->onFirstPage() ? 'true' : 'false' }}">Sebelumnya</a>
  <span class="chip on">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
  <a class="chip" href="{{ $paginator->nextPageUrl() ?? '#' }}" aria-disabled="{{ $paginator->hasMorePages() ? 'false' : 'true' }}">Berikutnya</a>
</div>
@endif
