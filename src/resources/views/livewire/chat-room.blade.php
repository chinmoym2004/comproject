<section>
    @if($allow_search)
      @include('member-search')
    @endif
    <div class="container py-1">
        <div class="row">
            
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
@endpush