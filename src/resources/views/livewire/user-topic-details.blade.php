<div>
    <section class="content-header forum-content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ url('/forums') }}">Forum</a></li>
                    <li class="breadcrumb-item">{{ $topic->forum->name }}</li>
                    <li class="breadcrumb-item active"><a href="{{ url('/forums/'.$topic->forum->slug) }}">Topics</a></li>
                </ol>
            </div>
            <div class="col-sm-12">
                <h5>{{ $topic->title }}</h5>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <p class="topic_by text-sm">By {{ '@'.$topic->user->name }} · {{ date('Y-m-d H:i:s',strtotime($topic->created_at)) }}</p>
                    <h5 class="topic_title mt-2 text-xl font-bold">{{ $topic->title }}</h5>
                    <div class="topic-body mt-2 prose break-words prose-indigo">
                        <?=$topic->body?>
                    </div>
                    <div class="topic_actions">
                        <div>
                            <button wire:click='upvote("{{ $topic->id }}")' class="btn  {{ $topic->uservoted()?'voted':'notvoted' }}">
                                <i class="fa fa-arrow-up"></i>&nbsp;&nbsp;Upvote ({{ $topic->upvote()->count() }})
                            </button>
                            <button class="btn replybtn" wire:click='actionEnablereply()'>
                                <i class="fa fa-comment-alt"></i>&nbsp;&nbsp;{{ $enablereply?'Discard Reply':'Reply' }}
                            </button>
                        </div>
                    </div>
                </div>

                @if($this->enablereply)
                <div class="card-footer newreply">
                    <form wire:ignore class="form" wire:submit.prevent='saveTopicComment()'>
                        <textarea wire:ignore.self class="form-control textarea" wire:model="comment_text" rows="4" placeholder="Write a reply..."></textarea>
                        <button class="btn btn-primary replysubmitbtn" type="submit">Reply</button>
                    </form>
                </div>
                @endif

                <div class="card-body">
                    <div class="comment">
                        @livewire('topic-comments',['topic'=>$topic])
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</div>