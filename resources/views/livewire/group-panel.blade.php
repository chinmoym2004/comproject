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
                   Groups
                </h3>
                <div class="card-tools d-flex">
                    <input wire:model="search" class="form-control mr-2 border-dark" type="text" placeholder="Search...">
                    <button class="btn btn-dark" wire:click="$emit('groupCreate')">
                        <i class="fa fa-plus"></i>  
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($groups->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <a wire:click.prevent="sortBy('title')" role="button" href="#">
                                        Title
                                        @include('livewire.sort-icon', ['field' => 'title'])
                                    </a>
                                </th>
                                
                                <th>
                                    Details
                                </th>

                                <th>
                                    Members
                                </th>

                                <th>
                                    <a wire:click.prevent="sortBy('created_by')" role="button" href="#">
                                        Created By
                                        @include('livewire.sort-icon', ['field' => 'created_by'])
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
                            @foreach ($groups as $group)
                                <tr>
                                    <td>{{ $group->title }}</td>
                                    <td>{{ $group->description }}</td>
                                    <td>{{ $group->members()->count() }}</td>
                                    <td>{{ $group->user->name }}</td>
                                    <td>{{ $group->created_at->diffForHumans() }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" wire:click="$emit('deletegroupTriggered', {{ $group->id }}, '{{ $group->name }}')">
                                            Delete
                                        </button>
                                    
                                        <button class="btn btn-sm btn-dark" wire:click="$emit('triggergroupEdit',{{ $group->id }})">
                                        Edit
                                        </button>
                                    
                                        <button class="btn btn-sm btn-warning" wire:click="$emit('fetchGroupmembers',{{ $group->id }})">
                                        Members
                                        </button>
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
                {{ $groups->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
    @if($updateMode)
        @include('livewire.groups_update')
    @else
        @include('livewire.groups_create')
    @endif

    @if($memberupdateMode)
        @include('livewire.groups_member_update')
    @endif
<div>