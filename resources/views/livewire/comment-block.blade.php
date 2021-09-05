<div class="row d-flex justify-content-center mt-2">
    <div class="col-md-12">
        <div class="card-body" key="{{ $comment->id }}{{ $comment->subcomment()->count() }}">
            <p>By {{ '@'.$comment->user->name }} · {{ date('Y-m-d H:i:s',strtotime($comment->created_at)) }}</p>
            <div class="topic-body">
                <?=$comment->comment_text?>
            </div>
            <div class="topic_actions">
                <div>
                    <button class="btn replybtn" wire:ignore dataid="{{ $comment->id }}">
                        <i class="fa fa-comment-alt"></i>&nbsp;&nbsp;{{ $enablereply?'Discard Reply':'Reply' }}
                    </button>
                </div>

                <div class="card-footer newreply d-none" wire:ignore>
                    <form class="form" wire:ignore wire:submit.prevent='saveTopicComment("{{ $comment->id }}")'>
                        <textarea wire:ignore class="form-control textarea" wire:model="comment_text" rows="4" placeholder="Write a reply..."></textarea>
                        <button class="btn btn-primary replysubmitbtn" type="submit">Reply</button>
                    </form>
                </div>
            </div>
        </div>
        @if($comment->subcomment()->count())
        <div class="loadnextlevelcomments">
            @if($comment->subcomment()->count())
                @foreach($comment->subcomment()->latest()->get() as $level2comments)
                    @include('livewire.comment-block',['comment'=>$level2comments])
                @endforeach
            @endif
        </div>
        @endif
    </div>
</div>
