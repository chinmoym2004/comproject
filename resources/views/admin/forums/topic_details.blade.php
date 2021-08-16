@extends('mainlayout')

@section('container')

<div class="mt-20">
<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('forum-admins') }}">Forums</a></li>
        <li class="breadcrumb-item"><a href="{{ url('forums/'.encrypt($topic->forum_id)) }}">{{ $topic->forum->name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Topic : {{ $topic->title }}</li>
    </ol>
</nav>
<div class="alert alert-success">
    This topic has {{ $topic->comments()->count() }} post @if($topic->comments()->latest()->first()) and was last updated {{ $topic->comments()->latest()->first()->creted_at }} by {{ $topic->comments()->latest()->first()->user->name }}.@endif
</div>
<div class="panel-heading">
    <?=$topic->body;?>
</div>
@livewire('topic-comments',['topic'=>$topic])
</div>
@endsection