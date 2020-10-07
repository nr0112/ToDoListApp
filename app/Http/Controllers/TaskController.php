<?php

namespace App\Http\Controllers;

// フォルダーモデルの読み込み
use App\Folder;
// タスクモデルの読み込み
use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * タスク一覧
     * @param Folder $folder
     * @return \Illuminate\View\View
     */

    // int $idを受け取るのではなく、Folderクラスの$folderを受け取る(エラー処理：ルートモデルバインディング)
    //→URL中のIDに該当するフォルダデータがコントローラメソッドに渡される
    public function index(Folder $folder)
    {
        $folders = Auth::user()->folders()->get();

        // 選ばれたフォルダに紐づくタスクを取得：クエリビルダー
        $tasks = $folder->tasks()->get();

        return view('tasks/index',[
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/create
     */

     /**
     * タスク作成フォーム
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder_id' => $folder->id,
        ]);
    }

    /**
     * タスク作成
     * @param Folder $folder
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function create(Folder $folder, CreateTask $request)
    {

    $task = new Task();
    $task->title = $request->title;
    $task->due_date = $request->due_date;
    $task->contents = $request->contents;

    // 選択したフォルダに紐づくタスクを作成している
    $folder->tasks()->save($task);

    return redirect()->route('tasks.index', [
        'folder' => $folder->id,
    ]);
    }

    /**
    * GET /folders/{id}/tasks/{task_id}/edit
   */
   /**
     * タスク編集フォーム
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder, Task $task)
    {
        // リレーションがないときのエラー処理
        $this->checkRelation($folder, $task);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * タスク編集
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
     public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->checkRelation($folder, $task);
    
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->contents = $request->contents;
        $task->save();

        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    // リレーションチェック・エラー処理の関数
    private function checkRelation(Folder $folder, Task $task)
    {
        // ユーザーのフォルダを取得
        Auth::user()->folders()->get();

        // フォルダとタスク(folder_idが割り振られている)の紐づきを確認
        // !==にすると型変換も含んでしまう→どちらも整数だが揃えるかどうか
        if ($folder->id != $task->folder_id){
            abort(404);
        }
    }

    /**
     * タスク削除
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);
        $task->delete();

        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    /**
     * タスク内容
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function showDetailedlTask(Folder $folder, Task $task)
    {
        return view('tasks/detailed', [
            'folder' => $task->folder_id,
            'task' => $task,
        ]);
    }
}