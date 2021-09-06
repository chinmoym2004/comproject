<div class="chat-header clearfix">
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
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>

                {{-- <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                  <span class="sr-only">Toggle Dropdown</span>
                </button> --}}
                <div class="dropdown-menu" role="menu" style="">
                  <a class="dropdown-item" href="#" wire:click='addmember("{{ encrypt($chat->id) }}")'>Add Member</a>
                  <a class="dropdown-item" href="#" wire:click='uploadFile("{{ encrypt($chat->id) }}")'>Upload File</a>
                  <a class="dropdown-item" href="#" wire:click='viewmembers("{{ encrypt($chat->id) }}")'>View Info</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Leave Chat</a>
                </div>
            </div>
            
            
        </div>
    </div>
</div>

<div class="chat-history">
    <ul class="m-b-0">
        @if($this->chat_messages)
            @foreach($this->chat_messages as $eachmessge)
                @if($eachmessge['is_me']==1)
                <li class="clearfix">
                    <div class="message-data text-right">
                        {{-- <span class="message-data-time">10:10 AM, Today</span> --}}
                        @if(isset($eachmessge['message']['time']) && is_object($eachmessge['message']['time']))
                        <span class="message-data-time">{{ date('Y-m-d H:i:s',strtotime($eachmessge['message']['time'])) }}</span>
                        @endif

                        <img src="{{ $eachmessge['user']['avatar'] }}" alt="avatar">
                    </div>
                    <div class="message other-message float-right">{{ $eachmessge['message']['body'] }}</div>
                </li>
                @else 
                <li class="clearfix">
                    <div class="message-data">
                        
                        <img src="{{ $eachmessge['user']['avatar'] }}" alt="avatar">
                        @if(isset($eachmessge['message']['time']) && is_object($eachmessge['message']['time']))
                        <span class="message-data-time">{{ date('Y-m-d H:i:s',strtotime($eachmessge['message']['time'])) }}</span>
                        @endif
                    </div>
                    <div class="message my-message">{{ $eachmessge['message']['body'] }}</div>                                    
                </li>
                @endif
            @endforeach
        @endif
        {{-- <li class="clearfix">
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
        </li> --}}
    </ul>
</div>
<div class="chat-message clearfix">
    <form wire:submit.prevent="saveChat">
        <div class="input-group mb-0">
            <input wire:ignore type="text" class="form-control" wire:model='chat_text' placeholder="Enter text here..."> 
            <div class="input-group-prepend">
                <button type="submit" class="input-group-text"><i class="fa fa-paper-plane"></i></button>
            </div>                                   
        </div>
    </form>
</div>


<script>
  chatid = "{{$chat->id ?? ''}}";
</script>

<script type="text/javascript">
    window.onscroll = function(ev) {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            window.livewire.emit('load-more');
        }
    };

    // $(document).on("scroll",".chat-history",function(ev) {
    //     if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    //         window.livewire.emit('load-more');
    //     }
    // };

    
</script>