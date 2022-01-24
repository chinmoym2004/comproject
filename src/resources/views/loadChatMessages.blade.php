<div class="chat" id="messagearea">
    <div class="chat-header clearfix" style="height:10%">
        <div class="row">
            <div class="col-lg-6">
                {{-- <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                </a> --}}
                <div class="chat-about">
                    <h6 class="m-b-0">{{ $chat->title }}</h6>
                    <small>Last seen: {{ $this->last_message }}</small>
                </div>
            </div>
            <div class="col-lg-6 hidden-sm text-right">
                {{-- <div class="btn-group">
                    <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>

                    <div class="dropdown-menu" role="menu" style="">
                        <a class="dropdown-item" href="#" wire:click='addmember("{{ encrypt($chat->id) }}")'>Add Member</a>
                        <a class="dropdown-item" href="#" wire:click='uploadFile("{{ encrypt($chat->id) }}")'>Upload File</a>
                        <a class="dropdown-item" href="#" wire:click='viewmembers("{{ encrypt($chat->id) }}")'>View Info</a>
                       
                    </div>
                </div> --}}
                
                
            </div>
        </div>
    </div>

    <div class="chat-history clearfix" id="messages-chat-history" style="height:80%">
        @if($messages_count>$perPage)
        <p class="text-center"><a href="#" wire:click="$emitSelf('loadMore')">Load More ({{$perPage}} of {{$messages_count}})</a></p>
        @endif

        <ul class="m-b-0">
            @if($this->chat_messages)
                @foreach($this->chat_messages as $eachmessge)
                    @if($eachmessge['is_me']==1)
                    <li class="clearfix">
                        <div class="message-data text-right">
                            {{-- <span class="message-data-time">10:10 AM, Today</span> --}}
                            @if(isset($eachmessge['message']['time']))
                            <span class="message-data-time">{{ $eachmessge['message']['time'] }}</span>
                            @endif

                            <img src="{{ $eachmessge['user']['avatar'] }}" alt="avatar">
                        </div>
                        <div class="message other-message float-right">
                            @if($eachmessge['message']['body']!='<p></p>')
                                <?=$eachmessge['message']['body'];?>
                            @endif

                            @foreach($eachmessge['files'] as $file)
                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix mt-5">
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

                    </li>
                    @else 
                    <li class="clearfix">
                        <div class="message-data">
                            
                            <img src="{{ $eachmessge['user']['avatar'] }}" alt="avatar">
                            @if(isset($eachmessge['message']['time']))
                            <span class="message-data-time">{{ $eachmessge['message']['time'] }}</span>
                            @endif
                        </div>

                        <div class="message my-message">
                            @if($eachmessge['message']['body']!='<p></p>')
                            <?=$eachmessge['message']['body'];?>
                            @endif 

                            @foreach($eachmessge['files'] as $file)
                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix mt-5">
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

                    </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>

    <div class="chat-message clearfix" style="height:10%">
        <form wire:submit.prevent="saveChat" enctype="multipart/form-data" wire:ignore>
            {{-- <div class="publisher bt-1 border-light" wire:ignore> 
                <input wire:ignore type="text" wire:model='chat_text' class="publisher-input divChatBox">
                
                <span class="publisher-btn file-group"><i class="fa fa-paperclip file-browser"></i></span> 
                <input type="file" id="uploads" wire:model='uploads' style="display: none" multiple/>
                <button class="publisher-btn text-info" type="submit"><i class="fa fa-paper-plane"></i></button> 
            </div> --}}

            <div class="input-group mb-0 userchatbox" wire:ignore>
                <div class="input-group-append mr-1">
                    <input type="file" id="files" wire:model='uploads' multiple style="display: none"/>
                    <button type="button" class="input-group-text" id="openFileupload"><i class="fa fa-file-upload"></i></button>
                </div>
                <input wire:ignore type="text" class="form-control divChatBox" wire:model='chat_text' placeholder="Enter text here..."> 
                <div class="input-group-prepend">
                    <button type="submit" class="input-group-text"><i class="fa fa-paper-plane"></i></button>
                </div>                                   
            </div>
        </form>
    </div>

    <script type="text/javascript">
        var simpsonAutocompleter='';
        var members = <?=$tag_members;?>;
        // window.onscroll = function(ev) {
        //     if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        //         window.livewire.emit('load-more');
        //     }
        // };

        simpsonAutocompleter = $.MentionsKinder.Autocompleter.Select2Autocompleter.extend({
            select2Options: {
                data : members
            }
        });

        $.MentionsKinder.defaultOptions.trigger['@'].autocompleter = simpsonAutocompleter;

        $('.divChatBox').mentionsKinder();

        $(document).on("keydown",".divChatBox",function(event){
            if(event.which=="13")
                return false;
        });

        $(document).on("change",".divChatBox",function(event){
            if(event.which=="13")
                return false;
            //console.log($(".mentions-kinder").html())
            @this.set('chat_text', $(".mentions-kinder").html());
            // if(event.which=="13")
            //     return false;
        });

        $(document).on("keydown",".select2-input",function (event) {
            console.log(event.which);
            if(event.which==27)
            {
                $(".select2-container").remove();
                $(".select2-offscreen").remove();
            }
        });
        
        


        $(document).ready(function(){

            $(".select2-container").remove();
            $(".select2-offscreen").remove();  

        });

        $(document).on('click',"#messages-chat-history .loadmore",function(event){
            event.preventDefault();
            window.livewire.emit('loadMore');
        });

        // $("#messages-chat-history").bind('scroll', function(){ 
        //     var top = $('#messages-chat-history ul').scrollTop();
        //     if ( top == 0 ) {
        //         window.livewire.emit('loadMore')
        //     }
        // });

        window.livewire.on('scroll', function()  {
            console.log("OK on it scroll");
          //$('#messages-chat-history').animate({
                 // scrollTop: $('#messages-chat-history ul li')[0].scrollHeight}, "slow");
        });
    </script>
</div>
