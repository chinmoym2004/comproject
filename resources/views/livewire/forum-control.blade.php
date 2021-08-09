<div>
    @if($updateMode)
        @include('livewire.forums_update')
    @else
        @include('livewire.forums_create')
    @endif

    <div class="row mb-4">
        <div class="row">
            <div class="col-4 mt-5">
                <button class="btn btn-success" wire:click="$emit('forumCreate')">Create Forum</button>
            </div>
            <div class="col-8 mt-5">
                <input wire:model="search" class="form-control" type="text" placeholder="Search Forum...">
            </div>
        </div>
    </div>

    <div class="row">
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
                        <a wire:click.prevent="sortBy('age')" role="button" href="#">
                            Topics
                            @include('livewire.sort-icon', ['field' => 'age'])
                        </a>
                    </th>

                    <th>
                        <a wire:click.prevent="sortBy('age')" role="button" href="#">
                            Posts
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
                @foreach ($forums as $forum)
                    <tr>
                        <td>{{ $forum->name }}</td>
                        <td>{{ $forum->topic_count }}</td>
                        <td>{{ $forum->post_count }}</td>
                        <td>{{ $forum->created_at->diffForHumans() }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="$emit('deleteForumTriggered', {{ $forum->id }}, '{{ $forum->name }}')">
                                Delete
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-dark" wire:click="$emit('triggerForumEdit',{{ $forum->id }})">
                            Edit
                            </button>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-dark" target="_blank" href="{{ url('forums/'.encrypt($forum->id)) }}">
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
            {{ $forums->links() }}
        </div>
    </div>
</div>