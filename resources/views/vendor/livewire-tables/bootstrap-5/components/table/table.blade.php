<div>
    <table id="{{ rand() }}" {{ $attributes->except('wire:sortable') }}
        class="pa-table table table-head-fixed _table-striped table-hover text-nowrap _table-sm">
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody {{ $attributes->only('wire:sortable') }}>
            {{ $body }}
        </tbody>
    </table>
</div>
