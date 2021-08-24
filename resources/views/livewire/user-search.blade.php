<div class="form-group searchusers">
        <input type="text" wire:model="term" class="form-control"/>
        <div wire:loading>Searching users...</div>
        <div wire:loading.remove>
            @if ($term == "")
            <div class="text-gray-500 text-sm">
                Enter a term to search for users.
            </div>
            @else

                @if($users->isEmpty())
                    <div class="text-gray-500 text-sm">
                        No matching result was found.
                    </div>
                @else
                    <ul>
                    @foreach($users as $user)
                        <li wire:click='selectedMember("{{ $user->id }}","{{$user->name}}({{$user->email}})")'>
                            <span>{{$user->name}}<br/>{{$user->email}}</span>
                        </li>
                    @endforeach
                    </ul>
                @endif
            @endif
        </div>
</div>
