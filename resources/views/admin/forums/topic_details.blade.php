@extends('mainlayout')

@section('page_header')
{{-- <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $topic->title }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('forum-admins') }}">Forums</a></li>
            <li class="breadcrumb-item"><a href="{{ url('forums/'.encrypt($topic->forum_id)) }}">{{ $topic->forum->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $topic->title }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section> --}}
@endsection

@section('container')
@livewire('topic-details',['topic'=>$topic])
@endsection

@section('custom-scripts')
<link rel="stylesheet" href="{{ asset('theme/plugins/summernote/summernote-bs4.min.css') }}">
<script src="{{ asset('theme/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection
