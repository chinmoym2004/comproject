<section>
    @if($allow_search)
      @include('member-search')
    @endif
    <div class="container py-1">
        <div class="row">
            <!-- <div class="col-md-6 col-lg-7 col-xl-8 chat" id="messagearea">
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
                                            @if($eachmessge['message']['time'])
                                            <p><?=$eachmessge['message']['body'];?></p>
                                            @endif
                                            <p class="meta"><time datetime="2018">{{  $eachmessge['message']['time']  }}</time></p>

                                            @foreach($eachmessge['files'] as $file)
                                            <br/>
                                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                                <li>
                                                    <div class="mailbox-attachment-info text-center d-flex justify-content-between">
                                                        <a href="#" class="mailbox-attachment-name">
                                                            {{ $file->file_name ?? $file['file_name'] }}
                                                            <br/>
                                                            <span class="text-sm">{{ formatSizeUnits($file->file_size ?? $file['file_size']) }}</span>
                                                        </a>
                                                        <div class="mailbox-attachment-size clearfix mt-1">
                                                            <a wire:click='downloadFile("{{ encrypt($file->id ?? $file['id']) }}")' class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            @endforeach
                                        </div>
                                    </div>
                                    @else
                                    <div class="media media-chat"> 
                                        <img class="avatar" src="{{ $eachmessge['user']['avatar'] }}" alt="...">
                                        <div class="media-body">
                                            @if($eachmessge['message']['time'])
                                            <p><?=$eachmessge['message']['body'];?></p>
                                            @endif

                                            <p class="meta"><time datetime="2018">{{  $eachmessge['message']['time']  }}</time></p>
                                            

                                            @foreach($eachmessge['files'] as $file)
                                            <br/>
                                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                                <li>
                                                    <div class="mailbox-attachment-info text-center d-flex justify-content-between">
                                                        <a href="#" class="mailbox-attachment-name">
                                                            {{ $file->file_name ?? $file['file_name'] }}
                                                            <br/>
                                                            <span class="text-sm">{{ formatSizeUnits($file->file_size ?? $file['file_size']) }}</span>
                                                        </a>
                                                        <div class="mailbox-attachment-size clearfix mt-1">
                                                            <a wire:click='downloadFile("{{ encrypt($file->id ?? $file['id']) }}")' class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            @endforeach
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
                        <form wire:submit.prevent='saveChat' enctype="multipart/form-data">
                            <div class="publisher bt-1 border-light" wire:ignore> 
                                {{-- <div id="divChatBox" wire:ignore class="publisher-input" contenteditable></div> --}}

                                <input wire:ignore type="text" wire:model='chat_text' class="publisher-input divChatBox">
                                
                                <span class="publisher-btn file-group"><i class="fa fa-paperclip file-browser"></i></span> 
                                <input type="file" id="uploads" wire:model='uploads' style="display: none" multiple/>
                                <button class="publisher-btn text-info" type="submit"><i class="fa fa-paper-plane"></i></button> 
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div> -->
            <div class="col-md-6 col-lg-7 col-xl-8">
                <div class="card chat-app">
                    @include('loadChatMessagesAdmin')
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
<link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

<style type="text/css">
    .chat-app .chat{
        margin-left: 0px;
    }
</style>

<script>
    var chatid = "{{$chat->id ?? ''}}";
    $(document).on("click",".file-browser",function (event) {
        console.log("OK");
        $('#uploads').trigger('click');
    });


    window.Echo.private('room-'+chatid)
      .listen('ChatBroadcast', (e) => {
            console.log(e);
          @this.call('incomingMessage', e.data);
    });

    $(function(){
        if ($("#page-content").length) {
            $('#page-content').animate({
                scrollTop: $('#page-content .media-chat')[0].scrollHeight
            }, "slow");
        }
    });

    $(document).on("keydown",".select2-input",function (event) {
        console.log(event.which);
        if(event.which==27)
        {
            $(".select2-container").remove();
            $(".select2-offscreen").remove();
        }
    });


    $(document).on("change",".divChatBox",function(event){
       // console.log($(".mentions-kinder").html())
        // if(event.which=="13")
        //     return false;
        @this.set('chat_text', $(".mentions-kinder").html());
    });
</script>
@endpush