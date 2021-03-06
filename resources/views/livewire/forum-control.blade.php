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
                   Forum Control Panel
                </h3>
                <div class="card-tools d-flex">
                    <input wire:model="search" class="form-control mr-2 border-dark" type="text" placeholder="Search...">
                    <button class="btn btn-dark" wire:click="$emit('fetchCategory')">
                        <i class="fa fa-plus"></i>  
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($forums->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                        Forum
                                        @include('livewire.sort-icon', ['field' => 'name'])
                                    </a>
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Group
                                </th>
                                
                                <th>
                                    <a wire:click.prevent="sortBy('topic_count')" role="button" href="#">
                                        Threads
                                        @include('livewire.sort-icon', ['field' => 'topic_count'])
                                    </a>
                                </th>

                                <th>
                                    <a wire:click.prevent="sortBy('post_count')" role="button" href="#">
                                        Posts
                                        @include('livewire.sort-icon', ['field' => 'post_count'])
                                    </a>
                                </th>

                                <th>
                                    <a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                                    Created at
                                    @include('livewire.sort-icon', ['field' => 'created_at'])
                                    </a>
                                </th>
                                <td>Status</td>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($forums as $forum)
                                <tr>
                                    <td><i class="text-muted fa fa-{{ $forum->is_public?'globe':'lock'}}" title="{{ $forum->is_public?'Public':'Private'}}"></i>&nbsp;&nbsp;{{ $forum->name }}</td>
                                    <td>{{ $forum->category->name }}</td>
                                    <td>{{ $forum->group->title ?? '' }}</td>
                                    <td>{{ $forum->topic_count }}</td>
                                    <td>{{ $forum->post_count }}</td>
                                    <td>{{ $forum->created_at->diffForHumans() }}</td>
                                    <td><span class="badge badge-{{ $forum->published ? 'success':'danger'}}">{{ $forum->published ? 'Published':'Not Published'}}</span></td>
                                    <td>

                                        @if(!$forum->published)
                                        <button class="btn btn-sm btn-info"  wire:click="approveForum({{ $forum->id }})">Publish Now</button>
                                        @else 
                                        <button class="btn btn-sm btn-danger"  wire:click="UndoapproveForum({{ $forum->id }})">Un-Publish Now</button>
                                        @endif 
                                    
                                        <button class="btn btn-sm btn-danger" wire:click="$emit('deleteForumTriggered', {{ $forum->id }}, '{{ $forum->name }}')">
                                            Delete
                                        </button>
                                    
                                        <button class="btn btn-sm btn-dark" wire:click="$emit('triggerForumEdit',{{ $forum->id }})">
                                        Edit
                                        </button>
                                    
                                        <a class="btn btn-sm btn-warning" href="{{ url('forum-admins/'.encrypt($forum->id)) }}">
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
                {{ $forums->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
    @if($updateMode)
        @include('livewire.forums_update')
    @endif 
    
    @if($createMode)
        @include('livewire.forums_create')
    @endif
<div>