@extends('mainlayout')

@section('page_header')
<section class="content-header forum-content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-10">
            <p>FORUM</p>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@section('container')
@livewire('user-forum')
@endsection