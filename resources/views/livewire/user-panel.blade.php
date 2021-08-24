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
                   Users
                </h3>
                <div class="card-tools d-flex">
                    <input wire:model="search" class="form-control mr-2 border-dark" type="text" placeholder="Search...">
                    {{-- <button class="btn btn-dark" wire:click="$emit('forumCreate')">
                        <i class="fa fa-plus"></i>  
                    </button> --}}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($users->count())
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
                                        Email
                                        @include('livewire.sort-icon', ['field' => 'age'])
                                    </a>
                                </th>

                                <th>
                                    <a wire:click.prevent="sortBy('age')" role="button" href="#">
                                        Title
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
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->title }}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" wire:click="$emit('deleteForumTriggered', {{ $user->id }}, '{{ $user->name }}')">
                                            Delete
                                        </button>
                                    
                                        <button class="btn btn-sm btn-dark" wire:click="$emit('triggeruserEdit',{{ $user->id }})">
                                        Edit
                                        </button>
                                    
                                        <a class="btn btn-sm btn-warning" href="{{ url('users/'.encrypt($user->id)) }}">
                                        Topics
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
                {{ $users->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
<div>