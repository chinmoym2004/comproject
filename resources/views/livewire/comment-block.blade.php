<div class="row d-flex justify-content-center mt-2">
    <div class="col-md-12">
        <div class="card {{ isset($level)?'pl-3 level2 pr-0 border-0':'p-3 level1' }}">
            <div class="d-flex justify-content-between align-items-center">
                <div class="user d-flex flex-row align-items-center">
                    <img src="{{ $comment->user->image() }}" alt="{{ $comment->user->name }}" width="30" class="user-img rounded-circle mr-2">
                    <span><small class="font-weight-bold text-primary">{{ $comment->user->name }}</small>
                </div> 
                <small>{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="ml-2">
                    <small><?php echo $comment->comment_text; ?></small>
                </div>
            </div>
        </div>
    </div>
</div>