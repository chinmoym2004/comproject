@extends('mainlayout')

@section('container')
<div class="mt-20">
    <h3> Chat Admin </h3>	
    @livewire('admin-chat-component') 
</div>
{{-- <livewire:admin-chat-component /> --}}
@endsection