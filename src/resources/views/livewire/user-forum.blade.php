<section class="content-header forum-content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-10">
            <p>FORUM</p>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>
<div class="col-sm-8">
    @foreach ($forums as $forum)
        <div class="card">
            <a class="card-header" href="{{ url('forums/'.$forum->slug) }}">
                <h2 class="forum-title text-xl font-medium">{{ $forum->name }}</h2>
                <div class="forum-details mt-2 text-sm text-gray-500">
                    <?=$forum->details;?>
                </div>
            </a>
            @if($forum->topics->count())
            <div class="card-footer">
                <p class="inline-block text-xs font-medium tracking-wider text-gray-500 uppercase">LAST ACTIVE</p>
                @php
                $latest = $forum->topics()->latest()->take(2)->get();
                @endphp
                @foreach ($latest as $each)
                    <div>
                        <h3 class="inline-block font-medium latesth3">
                            <a href="{{ url('forums/'.$forum->slug.'/t/'.$each->slug) }}">{{ $each->title }}</a>
                        </h3>  
                        <p class="inline-block text-gray-500"> by {{ '@'.$each->user->name }} . {{ $each->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    @endforeach
</div>