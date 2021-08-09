@extends('mainlayout')

@section('container')
<div class="mt-20">
    <h3> Forum Admin </h3>
    <div class="row">
        <div class="col-12">
            @livewire('forum-control')
        </div>
    </div>
</div>
@endsection