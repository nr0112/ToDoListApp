<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// FormRequestクラス=バリデーションについての記述
// FormRequestは1リクエストに対して1つ作成する
class CreateFolder extends FormRequest
{
    public function attributes()
    {
    return [
        'title' => 'フォルダ名',
    ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    //リクエストの内容に基づいた権限チェック
    public function authorize()
    {
        //今回は利用しない(リクエストを受け付ける)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    //入力欄ごとにチェックするルール定義
    public function rules()
    {
        return [
            //キーが入力欄、requiredは必須入力という意味
            'title' => 'required',
        ];
    }
}
