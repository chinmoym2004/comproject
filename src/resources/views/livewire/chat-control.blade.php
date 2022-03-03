<div>
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" wire:model="search" class="form-control" placeholder="Search...">
                        </div>
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            @if($rooms->count())
                                @foreach ($rooms as $room)
                                <li class="clearfix loadchataction {{ isset($active_room) && $active_room==$room->id?'active':''}}" wire:click="loadChatRoom('{{encrypt($room->id)}}')">
                                    <img src="{{ asset('img/user-placeholder.png') }}" alt="avatar">
                                    <div class="about">
                                        <div class="name">{{ strlen($room->title)>20?substr($room->title,0,20).'..':$room->title }}</div>
                                        @if($room->messages()->latest()->take(1)->first())
                                        <div class="status"> <i class="fa fa-circle offline"></i>{{$room->messages()->latest()->take(1)->first()->created_at->diffForHumans()}}</div>  
                                        @else
                                        <div class="status"> <i class="fa fa-circle offline"></i>Never</div>  
                                        @endif                                          
                                    </div>
                                    @php $tmp = $me->unreadedMessages($room->id)->count(); @endphp
                                    <div id="unread{{$room->id}}">@if($tmp)<span class="badge badge-success count">{{$tmp}}</span>@endif</div>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    
                        @if($active_room)
                            @include('loadChatMessages')
                        @else
                        <p class="text-muted notselecetd_text">
                            Select a chat to start
                        </p>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($see_members)
 @include('viewchatmember')
@endif

@if($upload_file)
 @include('fileUplaodModal')
@endif


@push('custom-scripts')
<link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
<script>
    $(document).on("click",".loadchataction",function () {
        $('.divChatBox').html("");
        $(".select2-container").remove();
        $(".select2-offscreen").remove();  
    });
</script>

    @if($rooms->count())
        @foreach ($rooms as $room)
        <script type="text/javascript">
        window.Echo.private('room-'+'{{$room->id}}')
          .listen('ChatBroadcast', (e) => {
            console.log(e);
              @this.call('incomingMessage', e.data);
        });
        </script>
        @endforeach
    @endif

@endpush