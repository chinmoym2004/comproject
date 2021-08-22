<div>
    @if($updateMode)
        @include('livewire.topic_update')
    @else
        @include('livewire.topic_create')
    @endif

    <div class="row mb-4">
        <div class="row">
            <div class="col-4 mt-5">
                <button class="btn btn-success" wire:click="$emit('topicCreate')">Create Topic</button>
            </div>
            <div class="col-8 mt-5">
                <input wire:model="search" class="form-control" type="text" placeholder="Search Topic...">
            </div>
        </div>
    </div>

    <div class="row">
        @if ($topics->count())
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <a wire:click.prevent="sortBy('title')" role="button" href="#">
                            Topics
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
                        Delete
                    </th>
                    <th>
                        Edit
                    </th>
                    <th></th>
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
                        </td>
                        <td>
                            <button class="btn btn-sm btn-dark" wire:click="$emit('triggerTopicEdit',{{ $topic->id }})">
                            Edit
                            </button>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-dark"  href="{{ url('topics/'.encrypt($topic->id)) }}">
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

    <div class="row">
        <div class="col">
            {{ $topics->links() }}
        </div>
    </div>
</div>