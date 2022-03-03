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
                   1-to-1 Chat Users
                </h3>
                <div class="card-tools d-flex">
                    <input wire:model="search" class="form-control mr-2 border-dark" type="text" placeholder="Search...">
                    <button class="btn btn-dark" wire:click="addUsertochat">
                        <i class="fa fa-plus"></i>  
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($onetoone->count())
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
                                    <a wire:click.prevent="sortBy('email')" role="button" href="#">
                                        Email
                                        @include('livewire.sort-icon', ['field' => 'email'])
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
                            @foreach ($onetoone as $eachone)
                                <tr>
                                    <td>{{ $eachone->name }}</td>
                                    <td>{{ $eachone->email }}</td>
                                    <td>{{ $eachone->created_at->diffForHumans() }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" wire:click="$emit('Remove1to1Triggered', '{{ encrypt($eachone->user_id) }}', '{{ $eachone->name }}')">
                                            Remove
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
                {{ $onetoone->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
    @if($addMemberModal)
        @include('livewire.addOnetooneMemberModal')
    @endif
<div>