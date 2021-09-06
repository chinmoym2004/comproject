<div>
    <div @if (is_numeric($refresh)) wire:poll.{{ $refresh }}ms
@elseif(is_string($refresh))
               @if ($refresh==='.keep-alive' ||
        $refresh==='keep-alive')
        wire:poll.keep-alive
    @elseif($refresh === '.visible' || $refresh === 'visible')
        wire:poll.visible
    @else
        wire:poll="{{ $refresh }}" @endif
        @endif
        class="container-fluid p-0"
        >

        @include('livewire-tables::bootstrap-5.includes.offline')

        @include('livewire-tables::bootstrap-5.includes.filters')

        @include('livewire-tables::bootstrap-5.includes.bulk-actions')
        @include('livewire-tables::bootstrap-5.includes.table')
        @include('livewire-tables::bootstrap-5.includes.pagination')

    </div>
    @isset($modalsView)
        @include($modalsView)
    @endisset
</div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        applySelectPicker();
        applyDatetimePicker();
        Livewire.hook('message.processed', (message, component) => {
            applySelectPicker();
            applyDatetimePicker();
        })
    });
</script>
