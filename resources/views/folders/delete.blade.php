@extends('layout')

@section('styles')
  @include('share.flatpickr.styles')
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">フォルダ削除の確認</div>
              <p class="panel-contents">以下のフォルダを削除するとフォルダ内のタスクも消えます。<br>本当に削除しますか？</p>
              <p class="panel-title">「  {{ $folder->title }}  」フォルダ</p>
              <div class="panel-botton">
                <form action="{{ route('folders.delete', ['folder' => $folder]) }}" method="POST" class="panel-contents">
                      @csrf
                      <button type="submit" class="btn btn-danger">削除</button>
                </form>
                <div class="panel-contents"><a href="{{ route('home') }}"><button class="btn btn-info">戻る</button></a></div>
              </div>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @include('share.flatpickr.scripts')
@endsection