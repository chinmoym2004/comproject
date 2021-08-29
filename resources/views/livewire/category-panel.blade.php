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
                   Categories
                </h3>
                <div class="card-tools d-flex">
                    <input wire:model="search" class="form-control mr-2 border-dark" type="text" placeholder="Search...">
                    <button class="btn btn-dark" wire:click="$emit('categoryCreate')">
                        <i class="fa fa-plus"></i>  
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($categories->count())
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
                                    Details
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
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->details }}</td>
                                    <td>{{ $category->user->name }}</td>
                                    <td>{{ $category->created_at->diffForHumans() }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" wire:click="$emit('deleteCategoryTriggered', {{ $category->id }}, '{{ $category->name }}')">
                                            Delete
                                        </button>
                                    
                                        <button class="btn btn-sm btn-dark" wire:click="$emit('triggerCategoryEdit',{{ $category->id }})">
                                        Edit
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
                {{ $categories->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
    @if($updateMode)
        @include('livewire.category_update')
    @else
        @include('livewire.category_create')
    @endif
<div>