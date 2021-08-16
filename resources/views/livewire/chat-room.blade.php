<section style="background-color: #eee;">
    <h5>Chat Room - {{ $chat->title }}</h5>
    <div class="container py-5">
      <div class="row">
  
        <div class="col-md-6 col-lg-7 col-xl-8">
  
          <ul class="list-unstyled" id="chatlist">
                @foreach($cmessages as $message)
                    @include('livewire.each_chat',['message'=>$message])
                @endforeach
          </ul>

          <ul class="list-unstyled">
              <li>
                <form wire:submit.prevent="saveChat">
                    <div class="form-outline">
                        <textarea class="form-control" wire:model='chat_text' rows="4" placeholder="Type here.."></textarea>
                        <label class="form-label" for="chat_text">Message</label>
                    </div>
                    <button type="submit" class="btn btn-info btn-rounded float-end">Send</button>
                </form>
              </li>
          </ul>
  
        </div>

        <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
  
            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Member</h5>
    
            <div class="card">
              <div class="card-body">
    
                <ul class="list-unstyled mb-0">
                    @foreach ($chat->members as $member)
                    <li class="p-2 border-bottom" style="background-color: #eee;">
                        <a href="#!" class="d-flex justify-content-between">
                          <div class="d-flex flex-row">
                              <img src="{{ asset('img/user-placeholder.png') }}" alt="avatar"
                              class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                              <div class="pt-1">
                              <p class="fw-bold mb-0">{{ $member->name }}</p>
                              </div>
                          </div>
                          <div class="pt-1">
                              <p class="small text-muted mb-1" wire:click="start1to1chat("{{ encrypt($member->user_id) }}")">Chat Now</p>
                          </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
    
              </div>
            </div>
    
          </div>
  
      </div>
  
    </div>
</section> 
@push('custom-scripts')
<script>
  var chatid = "{{$chat->id ?? ''}}";
  window.Echo.private(`chat-${chatid}-messages`)
    .listen('.newchat', (e) => {
        //console.log(e.data.is_on_going)
        cosole.log(e.data);
        //console.log(e);
    });
</script>
@endpush