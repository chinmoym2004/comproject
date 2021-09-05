@extends('mainlayout')

@section('container')
@livewire('user-topic-details',['topic'=>$topic])
@endsection

@section('custom-scripts')
<link rel="stylesheet" href="{{ asset('theme/plugins/summernote/summernote-bs4.min.css') }}">
<script src="{{ asset('theme/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection
