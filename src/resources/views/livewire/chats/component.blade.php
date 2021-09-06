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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                   Central Chat Panel
                </h3>
                <div class="card-tools d-flex">
                    <input wire:model="search" class="form-control mr-2 border-dark" type="text" placeholder="Search...">
                    <button class="btn btn-dark" wire:click="$emit('triggerCreate')">
                        <i class="fa fa-plus"></i>  
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
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
                                Actions
                            </th>
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
                                
                                    <button class="btn btn-sm btn-dark" wire:click="$emit('triggerEdit',{{ $chat->id }})">
                                    Edit
                                    </button>
                                
                                    <a class="btn btn-sm btn-warning" target="_blank" href="{{ url('chat-rooms/'.encrypt($chat->id)) }}">
                                    View History
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
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $chats->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
    @if($updateMode)
        @include('livewire.chats.update')
    @else
        @include('livewire.chats.create')
    @endif
</div>