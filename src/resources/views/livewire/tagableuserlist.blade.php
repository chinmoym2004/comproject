<ul class="autofillusers">
    @foreach ($this->taggableusers as $item)
    <li wire:click='selectedTagUser({{ $item->id }})'>
        {{ $item->name }}
    </li>
    @endforeach
</ul>