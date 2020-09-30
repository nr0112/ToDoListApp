<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\User;
// CreateFolderでバリデーションとの互換性あり
// use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;
use App\Http\Requests\EditFolder;
use App\Http\Requests\DeleteFolder;

use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    // このメソッドが呼び出されたとき、Requestクラスのインスタンス$requestにまとめて引数として渡してくれる
    public function create(CreateFolder $request)
    {
    // フォルダモデルのインスタンスを作成する(saveメソッドで属性を直埋め)
    $folder = new Folder();
    // タイトルに入力値を代入する　$request->title：リクエスト中の入力値をプロパティで取得
    $folder->title = $request->title;
    // インスタンスの状態をデータベースに書き込む(database saveメソッドを呼び出す)
    $folder->save();

    // ユーザーに紐づけて保存
    Auth::user()->folders()->save($folder);

    //リダイレクト処理*画面を作る必要はないので、viewメソッドは呼ばない
    return redirect()->route('tasks.index', [
        'folder' => $folder->id,
    ]);
    }

    /**
     * フォルダ編集フォーム
     * @param Folder $folder
     * @param User $user
     * @return \Illuminate\View\View
    * GET /folders/{folder}/edit
    */
    public function showEditForm(Folder $folder, User $user)
    {
        // リレーションがないときのエラー処理
        // $this->checkRelation($folder, $user);
        return view('folders/edit',[
            'folder' => $folder,
        ]);
    }

    /**
     * フォルダ編集
     * @param Folder $folder
     * @param EditFolder $request
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, EditFolder $request)
    {
        // $this->checkRelation($folder, $user);
        $folder->title = $request->title;
        $folder->save();

        return redirect()->route('tasks.index',[
            'folder' => $folder->id,
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

    // 確認画面
    public function showConfirmDestroy(Folder $folder)
    {
        // foldes>delete.blade.phpに遷移
        return view('folders/delete',[
            // folder->idにしない
            'folder' => $folder,
        ]);
    }

    public function destroy(Folder $folder, DeleteFolder $request)
    {
        $folder->id = $request->id;
        $folder->delete();

        // フォルダ情報を再び読み込む
        $folder = Auth::user()->folders()->first();

        return redirect()->route('tasks.index', [
            'folder' => $folder,
        ]);
    }
    
}
