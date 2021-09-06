@if ($paginationEnabled && $showPerPage)
<div class="d-flex pb-5">
    <div class="col-md-2">
        <select wire:model="perPage" id="perPage" class="form-control" style="width:auto">
            @foreach ($perPageAccepted as $item)
            <option value="{{ $item }}">{{ $item }}</option>
            @endforeach
        </select>
    </div>
    <div class=" col-md-10 d-flex justify-content-end pr-2">
        <div class="pr-2 pt-2">
            @lang('Showing :first to :last out of :total results', [
            'first' => $rows->count() ? $rows->firstItem() : 0,
            'last' => $rows->count() ? $rows->lastItem() : 0,
            'total' => $rows->total()
            ])
        </div>
        <div>
            {{ $rows->links() }}
        </div>
    </div>
</div>
@endif