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
                   Circular
                </h3>
                <div class="card-tools d-flex">
                    <input wire:model="search" class="form-control mr-2 border-dark" type="text" placeholder="Search...">
                    <button class="btn btn-dark" wire:click="$emit('fetchGroupForCircular')">
                        <i class="fa fa-plus"></i>  
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($circulars->count())
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
                                Posted by
                            </th>

                            

                            <th>
                                <a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                                Created at
                                @include('livewire.sort-icon', ['field' => 'created_at'])
                                </a>
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($circulars as $circular)
                            <tr>
                                <td>{{ $circular->title }}</td>
                                <td>{{ $circular->user->name }}</td>
                                <td>{{ $circular->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($circular->need_approval)
                                    <span class="badge badge-danger">Not Approved</span>
                                    @else 
                                    <span class="badge badge-success">Approved</span>
                                    @endif

                                    @if($circular->published)
                                    <span class="badge badge-info">Published</span>
                                    @else 
                                    <span class="badge badge-danger">Not Published</span>
                                    @endif
                                </td>
                                <td>
                                    @if($circular->need_approval)
                                        <button class="btn btn-sm btn-info"  wire:click="approveCircle({{ $circular->id }})">Approve Now</button>
                                    @endif 

                                    @if(!$circular->need_approval && !$circular->published)
                                        <button class="btn btn-sm btn-info"  wire:click="publishCircle({{ $circular->id }})">Publish Now</button>
                                    @endif 

                                    @if(!$circular->need_approval && $circular->published)
                                        <button class="btn btn-sm btn-danger"  wire:click="UnpublishCircle({{ $circular->id }})">Un-Publish Now</button>
                                    @endif 

                                    <button class="btn btn-sm btn-danger" wire:click="$emit('deletecircularTriggered', {{ $circular->id }}, '{{ $circular->name }}')">
                                        Delete
                                    </button>
                                
                                    <button class="btn btn-sm btn-dark" wire:click="$emit('triggercircularEdit',{{ $circular->id }})">
                                    Edit
                                    </button>
                                
                                    <a class="btn btn-sm btn-warning" href="{{ url('circular-admin/'.encrypt($circular->id)) }}">
                                    View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="alert alert-warning col-sm-12">
                        Your query returned zero results.
                    </div>
                @endif
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $circulars->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
    @if($updateMode)
        @include('livewire.circular_update')
    @endif

    @if($createMode)
        @include('livewire.circular_create')
    @endif
<div>