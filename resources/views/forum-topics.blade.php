@extends('mainlayout')

@section('container')
@livewire('user-forum-topics',['forum'=>$forum])
@endsection