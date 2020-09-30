<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        // ログインユーザーを取得
        // $user = Auth::user();
        // ログインユーザーに紐づくフォルダを一つ取得
        // $folder = $user->folders()->first();

        // ユーザーのフォルダを一つ取得
        $folder = Auth::user()->folders()->first();

        //まだ一つもフォルダを作っていなければホームページをレスポンス
        if(is_null($folder)){
            return view('home');
        }

        //フォルダがあればそのフォルダのタスク一覧にリダイレクト
        //routeヘルパ=名前付きルートのURL
        return redirect()->route('tasks.index', [
            'folder'=>$folder,
        ]);
    }
}
