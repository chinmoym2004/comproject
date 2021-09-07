{{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
<div class="container">
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card chat-app">
            <div id="plist" class="people-list">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
                <ul class="list-unstyled chat-list mt-2 mb-0">
                    <li class="clearfix">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                        <div class="about">
                            <div class="name">Vincent Porter</div>
                            <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>                                            
                        </div>
                    </li>
                    <li class="clearfix active">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                        <div class="about">
                            <div class="name">Aiden Chavez</div>
                            <div class="status"> <i class="fa fa-circle online"></i> online </div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="avatar">
                        <div class="about">
                            <div class="name">Mike Thomas</div>
                            <div class="status"> <i class="fa fa-circle online"></i> online </div>
                        </div>
                    </li>                                    
                    <li class="clearfix">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                        <div class="about">
                            <div class="name">Christian Kelly</div>
                            <div class="status"> <i class="fa fa-circle offline"></i> left 10 hours ago </div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <img src="https://bootdey.com/img/Content/avatar/avatar8.png" alt="avatar">
                        <div class="about">
                            <div class="name">Monica Ward</div>
                            <div class="status"> <i class="fa fa-circle online"></i> online </div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="avatar">
                        <div class="about">
                            <div class="name">Dean Henry</div>
                            <div class="status"> <i class="fa fa-circle offline"></i> offline since Oct 28 </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="chat">
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                            </a>
                            <div class="chat-about">
                                <h6 class="m-b-0">Aiden Chavez</h6>
                                <small>Last seen: 2 hours ago</small>
                            </div>
                        </div>
                        <div class="col-lg-6 hidden-sm text-right">
                            <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                            <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                            <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                            <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                        </div>
                    </div>
                </div>
                <div class="chat-history">
                    <ul class="m-b-0">
                        <li class="clearfix">
                            <div class="message-data text-right">
                                <span class="message-data-time">10:10 AM, Today</span>
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                            </div>
                            <div class="message other-message float-right"> Hi Aiden, how are you? How is the project coming along? </div>
                        </li>
                        <li class="clearfix">
                            <div class="message-data">
                                <span class="message-data-time">10:12 AM, Today</span>
                            </div>
                            <div class="message my-message">Are we meeting today?</div>                                    
                        </li>                               
                        <li class="clearfix">
                            <div class="message-data">
                                <span class="message-data-time">10:15 AM, Today</span>
                            </div>
                            <div class="message my-message">Project has been already finished and I have results to show you.</div>
                        </li>
                    </ul>
                </div>
                <div class="chat-message clearfix">
                    <div class="input-group mb-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-send"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Enter text here...">                                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> --}}

<section style="background-color: #eee;">

    @if($allow_search)
      @include('member-search')
    @endif

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
                        <textarea wire:self.ignore class="form-control" wire:model='chat_text' rows="4" placeholder="Type here.."></textarea>
                        <label class="form-label" for="chat_text">Attachments: <input type="file" name="file[]" /></label>
                        
                    </div>
                    <button type="submit" class="btn btn-info btn-rounded float-end">Send</button>
                </form>
              </li>
          </ul>
  
        </div>

        <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
  
            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Member</h5>
            <a class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Members</a>
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
                          @if($member->id!=$me->id)
                          <div class="pt-1">
                              <p class="small text-muted mb-1" wire:click='start1to1chat("{{ encrypt($member->id) }}")'>Chat Now</p>
                          </div>
                          @endif
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
</scrip>
@endpush