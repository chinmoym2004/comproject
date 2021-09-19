<section>
    @if($allow_search)
      @include('member-search')
    @endif
    <div class="container py-1">
        <div class="row">
            <div class="col-md-6 col-lg-7 col-xl-8 chat" id="messagearea">
                <div class="page-content page-container" id="page-content">
                    <div class="card card-bordered">
                        <div class="card-header">
                            <h4 class="card-title"><strong>Chat History</strong></h4> <a class="btn btn-xs btn-secondary">{{ $chat->title }}</a>
                        </div>

                        <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:70vh !important;">
                            @if($this->chat_messages)
                                @foreach($this->chat_messages as $eachmessge)
                                    @if($eachmessge['is_me']==1)
                                    <div class="media media-chat media-chat-reverse">
                                        <div class="media-body">
                                            <p> {{ $eachmessge['message']['body'] }}</p>
                                            <p class="meta"><time datetime="2018">{ $eachmessge['message']['time'] }}</time></p>
                                        </div>
                                    </div>
                                    @else
                                    <div class="media media-chat"> 
                                        <img class="avatar" src="{{ $eachmessge['user']['avatar'] }}" alt="...">
                                        <div class="media-body">
                                            <p>{{ $eachmessge['message']['body'] }}</p>
                                            <p class="meta"><time datetime="2018">{ $eachmessge['message']['time'] }}</time></p>
                                        </div>
                                    </div>  
                                    @endif
                                @endforeach
                            @endif

                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                                <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                            </div>
                        </div>
                        <form wire:submit.prevent='saveChat'>
                            <div class="publisher bt-1 border-light"> 
                                <input class="publisher-input" type="text" wire:model='chat_text' placeholder="Write something..">
                                <span class="publisher-btn file-group"><i class="fa fa-paperclip file-browser"></i></span> 
                                <input type="file" id="uploads" wire:model='uploads' style="display: none" multiple/>
                                <button class="publisher-btn text-info" type="submit"><i class="fa fa-paper-plane"></i></button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card card-bordered">
                    <div class="card-header">
                        <h4 class="card-title">Members</h4>
                        <div clss="card-tool">
                            <a class="btn btn-primary pull-right" wire:click='addMember({{ $chat->id }})'><i class="fa fa-plus"></i>&nbsp; Add People</a>
                        </div>
                    </div>
                    <div class="card-body">
            
                        <ul class="list-unstyled mb-0">
                            @foreach ($chat->members as $member)
                            <li class="p-2 mb-1 border-bottom" style="background-color: #eee;">
                                <a href="#!" class="d-flex justify-content-between">
                                <div class="d-flex flex-row">
                                    <img src="{{ asset('img/user-placeholder.png') }}" alt="avatar"
                                    class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                    <div class="pt-3 pl-1">
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

    @if($memberupdateMode)
        @include('livewire.chat_member_update')
    @endif

</section> 

@push('custom-scripts')
<link rel="stylesheet" href="{{ asset('css/adminchat.css') }}" />
<script>
  var chatid = "{{$chat->id ?? ''}}";
  window.Echo.private(`chat-${chatid}-messages`)
    .listen('.newchat', (e) => {
        //console.log(e.data.is_on_going)
        cosole.log(e.data);
        //console.log(e);
    });

    $(document).on("click",".file-browser",function (event) {
        console.log("OK");
        $('#uploads').trigger('click');
    });

    $(function(){
        if ($("#page-content").length) {
            $('#page-content').animate({
                scrollTop: $('#page-content .media-chat')[0].scrollHeight
            }, "slow");
        }
    });
</script>
@endpush