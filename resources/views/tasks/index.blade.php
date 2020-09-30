@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-4">
        <nav class="panel panel-default">
          <div class="panel-heading">フォルダ</div>
          <div class="panel-body">
            <a href="{{ route('folders.create') }}" class="btn btn-default btn-block">
              フォルダを追加する
            </a>
          </div>
          <div class="list-group">
          <!-- コントローラーから渡されたデータを参照 -->
            @foreach($folders as $folder)
            <!-- route関数の結果をhrefの値として出力(route関数はルーティングの設定からURLを作り出す関数) -->
            <!-- ループしているフォルダデータのうち、閲覧されているフォルダのIDとID値が合致する場合のみactiveを出力 -->
            <div class="list-content">
              <div class="list-item item1">
                <a href="{{ route('tasks.index', ['folder' => $folder->id]) }}" 
                  class="list-group-item {{ $current_folder_id === $folder->id ? 'active' : '' }}">
                  <!-- 変数の値の展開 -->
                  {{ $folder->title }}
                </a>
              </div>
              <div class="list-item item2">
                <!-- フォルダ編集 -->
                <div class="item2-1">
                  <a class="btn btn-outline-primary btn-sm" href="{{ route('folders.edit', ['folder' => $folder->id]) }}" role="button">編集</a>
                </div>
                <div class="item2-2">
                  <!-- フォルダ削除 -->
                    @csrf
                    <a class="btn btn-outline-primary btn-sm" href="{{ route('folders.delete', ['folder' => $folder->id]) }}" role="button">削除</a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </nav>
      </div>
      <div class="column col-md-8">
        <!-- ここにタスクが表示される -->
        <div class="panel panel-default">
         <div class="panel-heading">タスク</div>
         <div class="panel-body">
           <div class="text-right">
             <a href="{{ route('tasks.create', ['folder' => $current_folder_id]) }}" class="btn btn-default btn-block">
               タスクを追加する
             </a>
           </div>
         </div>
         <table class="table">
           <thead>
           <tr>
             <th>タイトル</th>
             <th>状態</th>
             <th>期限</th>
             <th></th>
           </tr>
           </thead>
           <tbody>
             @foreach ($tasks as $task)
               <tr>
                 <td>{{ $task->title }}</td>
                 <td>
                   <span class="badge {{ $task->status_class }}">{{ $task->status_label }}</span>
                 </td>
                 <td>{{ $task->formatted_due_date }}</td>
                 <!-- タスク編集ボタン -->
                 <td>
                   <a href="{{ route('tasks.edit', ['folder' => $task->folder_id, 'task' => $task->id]) }}">
                    <button type="submit" class="btn btn-primary">編集</button>
                   </a>
                 </td>
                 <!-- タスク削除ボタン -->
                 <td>
                 <form action="{{ route('tasks.delete', ['folder' => $task->folder_id, 'task' => $task->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">削除</button>
                 </form>
                </td>
               </tr>
             @endforeach
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>
@endsection
