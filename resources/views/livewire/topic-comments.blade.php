<div>
    <form wire:ignore.self class="form-horizontal commentbox" wire:submit.prevent='submit' enctype="multipart/form-data">
        <div class="block-box post-input-tab forum-post-input">
            <div class="media p-0 mt-3">
                
                <div class="media-body">
                        <input type="hidden" wire:model="reference"/>
                        <input type="hidden" wire:model="reference_id"/>
                        <input type="hidden" wire:model="parent_id"/>
                        <input type="hidden" wire:model="has_file"/>
                        <textarea wire:ignore.self wire:model="comment_text" id="comment_text" class="form-control textarea" placeholder="Share what are you thinking here . . ." rows="2"></textarea>
                </div>
            </div>
            <div class="post-footer">
                <div class="insert-btn">
                    
                </div>
                <div class="submit-btn">
                    <button type="submit" class="btn btn-primary btn-sm btn-block">Post in Topic</button>
                </div>
            </div>
        </div>
    </form>

    <div id="existing_comment_section" class="container mt-5 p-0" wire:ignore.self>
        @if(isset($comments)) 
            @foreach($comments as $comment)
                @include('livewire.comment-block',['comment'=>$comment])
            @endforeach
        @endif
    </div>
</div>