@if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger" role="alert">
        {{ session()->get('error') }}
    </div>
@endif


<div>
    @if($updateMode)
        @include('livewire.chats.update')
    @else
        @include('livewire.chats.create')
    @endif
    <div class="row mb-4">
        <div class="row">
            <div class="col-4 mt-5">
                <button class="btn btn-success" wire:click="$emit('triggerCreate')">Create New User</button>
            </div>
            <div class="col-8 mt-5">
                <input wire:model="search" class="form-control" type="text" placeholder="Search Users...">
            </div>
        </div>
    </div>

    <div class="row">
        @if ($chats->count())
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <a wire:click.prevent="sortBy('name')" role="button" href="#">
                            Name
                            @include('livewire.sort-icon', ['field' => 'name'])
                        </a>
                    </th>
                    {{-- <th>
                        <a wire:click.prevent="sortBy('email')" role="button" href="#">
                            Email
                            @include('livewire.sort-icon', ['field' => 'email'])
                        </a>
                    </th>
                    <th>
                        <a wire:click.prevent="sortBy('address')" role="button" href="#">
                            Address
                            @include('livewire.sort-icon', ['field' => 'address'])
                        </a>
                    </th> --}}
                    <th>
                        <a wire:click.prevent="sortBy('age')" role="button" href="#">
                            Number Of members
                            @include('livewire.sort-icon', ['field' => 'age'])
                        </a>
                    </th>
                    <th>
                        <a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                        Created at
                        @include('livewire.sort-icon', ['field' => 'created_at'])
                        </a>
                    </th>
                    <th>
                        Delete
                    </th>
                    <th>
                        Edit
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chats as $chat)
                    <tr>
                        <td>{{ $chat->title }}</td>
                        {{-- <td>{{ $user->email }}</td>
                        <td>{{ $user->address }}</td> --}}
                        <td>{{ $chat->members->count() }}</td>
                        <td>{{ $chat->created_at->format('m-d-Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="$emit('deleteTriggered', {{ $chat->id }}, '{{ $chat->title }}')">
                                Delete
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-dark" wire:click="$emit('triggerEdit',{{ $chat->id }})">
                            Edit
                            </button>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-dark" target="_blank" href="{{ url('chat-rooms/'.encrypt($chat->id)) }}">
                            Join
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="alert alert-warning">
                Your query returned zero results.
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col">
            {{ $chats->links() }}
        </div>
    </div>
</div>