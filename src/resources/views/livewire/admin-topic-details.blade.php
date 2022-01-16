<div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">    
        @livewire('topic-comments',['topic'=>$topic])
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
        <div class="card">
            <div class="card-header">
                <b>Topic</b>
                <div class="card-tools text-muted">
                    <p><a href="{{ url('forum-admins') }}">Forums</a>&nbsp;&nbsp;<i class="fa fa-angle-right text-muted"></i>&nbsp;&nbsp;<a href="{{ url('forum-admins/'.encrypt($topic->forum_id)) }}">{{ $topic->forum->name }}</a>&nbsp;&nbsp;<i class="fa fa-angle-right text-muted"></i>&nbsp;&nbsp;Topics</p>
                </div>
            </div>
            <div class="card-body">
                <h3 class="text-primary"><i class="fas fa-paint-brush"></i>&nbsp;{{ $topic->title }}</h3>
                <p class="text-muted">
                    <?=$topic->body;?>
                </p>
                <br>
                <div class="text-muted">
                    <p class="text-sm">Forum Name
                        <b class="d-block"><a href="{{ url('forum-admins/'.encrypt($topic->forum_id)) }}">{{ $topic->forum->name }}</a></b>
                    </p>
                    <p class="text-sm">Published On
                        <b class="d-block">{{ $topic->forum->published_at }}</b>
                    </p>

                    <p class="text-sm">Total Post
                        <b class="d-block">{{ $topic->comments->count() }}</b>
                    </p>

                    <p class="text-sm">Total Upvotes
                        <b class="d-block">{{ $topic->forum->published_at }}</b>
                    </p>

                    <p class="text-sm">Total Participants
                        <b class="d-block">{{ $topic->forum->published_at }}</b>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>