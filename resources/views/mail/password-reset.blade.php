
パスワード再設定の要求がありました。<br>
以下のリンクからパスワードを再設定してください！<br>

<a href="{{ route('password.reset', ['token' => $token]) }}">
  パスワード再設定
</a>