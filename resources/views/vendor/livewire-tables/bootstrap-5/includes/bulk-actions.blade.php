@if (count($bulkActions))
    <div class="pl-3 pr-3 pb-1">
        <div class="row">
            <div class="col-md-2">
                <div class="dropdown">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                        Bulk Actions
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu">
                        @foreach ($bulkActions as $action => $title)
                            <a href="javascript:;" class="dropdown-item" wire:click.prevent="{{ $action }}"
                                wire:key="bulk-action-{{ $action }}">{!! $title !!}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
