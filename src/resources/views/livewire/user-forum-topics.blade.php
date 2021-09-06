<div>
    <section class="content-header forum-content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-10">
                <p class="space-x-2 text-gray-500">FORUM</p>
                <h5 class="text-2xl font-bold">{{ $forum->name }}</h5>
                <?=$forum->details;?>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary vcenter" wire:click="$emit('userTopicCreate')">New Thread</button>
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </section>

    @foreach ($threads as $thread)
    <div class="col-sm-12 echthread">
        <div class="card">
            <div class="card-header text-sm">
                By {{ '@'.$thread->user->name }} . {{ $thread->created_at->diffForHumans() }} . {{ $thread->comments->count().' replies' }}
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <div class="text-center">
                        <div wire:click='upvote("{{ $thread->id }}")' class="upvotediv">
                            <span class="upvote">
                                <i class="fa fa-arrow-circle-up fa-2x {{ $thread->uservoted()?'votes':'novote' }}"></i>
                            </span>
                        </div>
                        <div>
                            {{ $thread->upvote()->count() }}
                        </div>
                    </div>
                    <div class="threadcard" onclick="window.location.href='{{ url('forums/'.$thread->forum->slug.'/t/'.$thread->slug) }}'">
                        <h5 class="threadtitle">{{ $thread->title }}</h5>
                        <p class="threadbody text-gray-500">{{ $thread->body }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @include('livewire.topic_create')
</div>