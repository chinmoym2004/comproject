<div>
    @if($comments->count())   
    <div class="card">
        <div class="card-body">
            <div id="existing_comment_section" key="{{ $totalcomment }}" class="container p-0">
                @if(isset($comments)) 
                    @foreach($comments as $comment)
                        @include('livewire.comment-block',['comment'=>$comment])
                    @endforeach
                @endif
            </div>
        </div>
        @if($comments->hasPages())
        <div class="card-footer clearfix">
            {{ $comments->links('vendor.pagination.bootstrap-4') }}
        </div>
        @endif
    </div>
    @else
    <p class="text-muted text-center pt-3">No activity from user</p>
    @endif

    <script>
        $(document).on("click", ".replybtn", function(event) {
            event.preventDefault();
            $(".comment .newreply").addClass("d-none");
            @this.set('parent_id', $(this).attr('dataid'));
            $(this).closest(".topic_actions").find(".newreply").removeClass("d-none");
        });
    </script>

</div>