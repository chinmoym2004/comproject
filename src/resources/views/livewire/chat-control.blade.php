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
                                <li class="clearfix {{ $active_room==$room->id?'active':''}}" wire:click='loadChatRoom("{{ encrypt($room->id) }}")'>
                                    
                                    <img src="{{ asset('img/user-placeholder.png') }}" alt="avatar">
                                    {{-- <div class="flex-shrink-0 mr-4 symbol symbol-65 symbol-circle">
                                        <span class="symbol symbol-lg-50 symbol-25 symbol-light-success">
                                            <span class="symbol-label font-size-h5 font-weight-bold">Sp</span>
                                        </span>
                                    </div> --}}
                                    <div class="about">
                                        <div class="name">{{ strlen($room->title)>20?substr($room->title,0,20).'..':$room->title }}</div>
                                        @if($room->messages()->latest()->take(1)->first())
                                        <div class="status"> <i class="fa fa-circle offline"></i>{{$room->messages()->latest()->take(1)->first()->created_at->diffForHumans()}}</div>  
                                        @else
                                        <div class="status"> <i class="fa fa-circle offline"></i>Never</div>  
                                        @endif                                          
                                    </div>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="chat" id="messagearea">
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
    window.Echo.private(`chat-${chatid}-messages`)
      .listen('.newchat.newmessage', (e) => {
          //console.log(e.data.is_on_going)
          cosole.log(e.data);
          //console.log(e);
      });
</script>
@endpush