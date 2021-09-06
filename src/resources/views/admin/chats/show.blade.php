@extends('mainlayout')

@section('container')
<div class="mt-20">
@livewire('chat-room',['chat'=>$chat])
</div>
@endsection