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
                    Threads
                </h3>
                <div class="card-tools d-flex">
                    <input wire:model="search" class="form-control mr-2 border-dark" type="text" placeholder="Search...">
                    <button class="btn btn-dark" wire:click="$emit('topicCreate')">
                        <i class="fa fa-plus"></i>  
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($topics->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <a wire:click.prevent="sortBy('title')" role="button" href="#">
                                    Thread
                                    @include('livewire.sort-icon', ['field' => 'title'])
                                </a>
                            </th>
                            
                        

                            <th>
                                <a wire:click.prevent="sortBy('comment_count')" role="button" href="#">
                                    Comments
                                    @include('livewire.sort-icon', ['field' => 'comment_count'])
                                </a>
                            </th>

                            <th>
                                <a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                                Created at
                                @include('livewire.sort-icon', ['field' => 'created_at'])
                                </a>
                            </th>
                            <th>
                                Action    
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topics as $topic)
                            <tr>
                                <td>{{ $topic->title }}</td>
                                <td>{{ $topic->comments->count() }}</td>
                                <td>{{ $topic->created_at->diffForHumans() }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" wire:click="$emit('deleteTopicTriggered', {{ $topic->id }}, '{{ $topic->title }}')">
                                        Delete
                                    </button>
                                
                                    <button class="btn btn-sm btn-dark" wire:click="$emit('triggerTopicEdit',{{ $topic->id }})">
                                    Edit
                                    </button>
                                
                                    <a class="btn btn-sm btn-success"  href="{{ url('topic-admins/'.encrypt($topic->id)) }}">
                                    View
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

            <div class="card-footer clearfix">
                {{ $topics->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>

    @if($updateMode)
        @include('livewire.topic_update')
    @else
        @include('livewire.topic_create')
    @endif

</div>