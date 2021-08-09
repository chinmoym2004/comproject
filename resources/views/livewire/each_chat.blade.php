@if($message->user->id!=$me->id)
<li class="d-flex justify-content-between mb-4">
    <img src="{{ asset('img/user-placeholder.png') }}" alt="avatar"
      class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
    <div class="card" style="width: 100%">
      <div class="card-header d-flex justify-content-between p-3">
        <p class="fw-bold mb-0">{{ $message->user->name }}</p>
        <p class="text-muted small mb-0"><i class="far fa-clock"></i> {{ $message->created_at->diffForHumans() }}</p>
      </div>
      <div class="card-body">
        <p class="mb-0">
          {{ $message->body }}
        </p>
      </div>
    </div>
</li>
@else
<li class="d-flex justify-content-between mb-4">
    
    <div class="card" style="width: 100%">
      <div class="card-header d-flex justify-content-between p-3">
        <p class="fw-bold mb-0">{{ $message->user->name }}</p>
        <p class="text-muted small mb-0"><i class="far fa-clock"></i> {{ $message->created_at->diffForHumans() }}</p>
      </div>
      <div class="card-body">
        <p class="mb-0">
          {{ $message->body }}
        </p>
      </div>
    </div>
    <img src="{{ asset('img/user-placeholder.png') }}" alt="avatar"
      class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
</li>
@endif