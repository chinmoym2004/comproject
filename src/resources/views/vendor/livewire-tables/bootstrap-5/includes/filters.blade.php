@if ($filtersView || count($customFilters))
    <div class="pl-3 pb-3 pr-3">

        @if ($filtersView)
            @include($filtersView)
            @if (!empty($filter))

                <div class="row">
                    <div class="col-md-3 pt-0">
                        <a href="#" wire:click.prevent="resetSearchFilters" class="btn btn-danger">
                            @lang('Clear')
                        </a>
                    </div>
                </div>
            @endif
        @elseif (count($customFilters))
            <div class=" col-md-12 d-flex justify-content-start pr-2">
                @foreach ($customFilters as $key => $filter)
                    <div wire:key="filter-{{ $key }}" class="p-3">
                        @if ($filter->isSelect())
                            <label for="filter-{{ $key }}" class="mb-2">
                                {{ $filter->name() }}
                            </label>

                            <select onclick="event.stopPropagation();" wire:model="filters.{{ $key }}"
                                id="filter-{{ $key }}" class="form-control">
                                @foreach ($filter->options() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                @endforeach
            </div>

            @if (count(array_filter($filters)) && !(count(array_filter($filters)) === 1 && isset($filters['search'])))
            <div class="col-md-3 pt-5">

                <a href="#" wire:click.prevent="resetFilters" class="btn btn-primary">
                    @lang('Clear')
                </a>
            </div>
        @endif
@endif



</div>
@endif
