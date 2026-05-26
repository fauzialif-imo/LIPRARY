@if ($paginator->hasPages())
<div style="display:flex;gap:4px;align-items:center;justify-content:flex-end">
  @if ($paginator->onFirstPage())
    <span style="padding:4px 10px;border-radius:7px;border:1px solid var(--border);background:var(--surface);color:var(--muted-2);font-size:.72rem;cursor:not-allowed">&laquo;</span>
  @else
    <a href="{{ $paginator->previousPageUrl() }}" style="padding:4px 10px;border-radius:7px;border:1px solid var(--border);background:var(--white);color:var(--ink);font-size:.72rem">&laquo;</a>
  @endif
  @foreach ($elements as $element)
    @if (is_string($element))
      <span style="padding:4px 8px;font-size:.72rem;color:var(--muted)">{{ $element }}</span>
    @endif
    @if (is_array($element))
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
          <span style="padding:4px 10px;border-radius:7px;background:var(--gold);color:var(--navy-dark);font-size:.72rem;font-weight:700">{{ $page }}</span>
        @else
          <a href="{{ $url }}" style="padding:4px 10px;border-radius:7px;border:1px solid var(--border);background:var(--white);color:var(--ink);font-size:.72rem">{{ $page }}</a>
        @endif
      @endforeach
    @endif
  @endforeach
  @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" style="padding:4px 10px;border-radius:7px;border:1px solid var(--border);background:var(--white);color:var(--ink);font-size:.72rem">&raquo;</a>
  @else
    <span style="padding:4px 10px;border-radius:7px;border:1px solid var(--border);background:var(--surface);color:var(--muted-2);font-size:.72rem;cursor:not-allowed">&raquo;</span>
  @endif
</div>
@endif
