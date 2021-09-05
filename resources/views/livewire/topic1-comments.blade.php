<div>       
    <div class="card">
        <div class="card-body">
            <div id="existing_comment_section" class="container mt-5 p-0">
                @if(isset($comments)) 
                    @foreach($comments as $comment)
                        @include('livewire.comment-block',['comment'=>$comment])
                    @endforeach
                @endif
            </div>
        </div>
        <div class="card-footer clearfix">
            {{ $comments->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>