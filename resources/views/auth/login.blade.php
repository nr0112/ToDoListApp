@extends('layout')

@section('content')
  <div class="container">
    <div class="content-info">
      <img src="{{ asset('img/flower2.png') }}" class="img-flower" alt="花のイラスト">
      <img src="{{ asset('img/info-title.png') }}" class="img-title" alt="「いつかやろう」を思い出すためのToDo管理アプリ。なかなか手をつけられないタスクやいつか達成したい目標を記録しておきましょう">
      <img src="{{ asset('img/flower2.png') }}" class="img-flower" alt="花のイラスト">
    </div>
    <div class="login-panel">
      <img src="{{ asset('img/cat.png') }}" class="img-cat" alt="猫のイラスト">
      <div class="login-heading">ログイン</div>
      <div class="login-body">
        @if($errors->any())
          <div class="alert alert-danger">
            @foreach($errors->all() as $message)
              <p>{{ $message }}</p>
            @endforeach
          </div>
        @endif
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="text" class="login-form" id="email" name="email" value="{{ old('email') }}"/>
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" class="login-form" id="password" name="password" />
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">送信</button>
          </div>
        </form>
      </div>
    </div>
    <div class="text-center">
      <a href="{{ route('password.request') }}">パスワードの変更はこちらから</a>
    </div>
  </div>
@endsection
