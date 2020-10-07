@extends('layout')

@section('styles')
  @include('share.flatpickr.styles')
@endsection

@section('content')
<div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">タスクの詳細</div>
          <div class="panel-body">
            <h1 class="panel-title">内容</h1>
            <p class="panel-contents">{{ $task->contents }}</p>
            <h1 class="panel-title">タスクを作成した日</h1>
            <p class="panel-contents">{{ $task->formatted_created_at }}</p>
            <div class="panel-contents"><a href="{{ route('home') }}"><button class="btn btn-info">戻る</button></a></div>
          </div>
        </nav>
      </div>
    </div>
</div>

@endsection

@section('scripts')
  @include('share.flatpickr.scripts')
@endsection