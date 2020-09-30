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
              <p>フォルダを削除するとこのフォルダ内のタスクも消えます。<br>本当に削除しますか？</p>
              <p>{{ $folder->title }}</p>
              <form action="{{ route('folders.delete', ['folder' => $folder]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
              </form>
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