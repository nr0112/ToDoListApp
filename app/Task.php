<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{

    //タスクの状態
    const STATUS = [
        1 => [ 'label' => '未着手', 'class'=>'badge-warning'],
        2 => [ 'label' => '着手中', 'class'=>'badge-info'],
        3 => [ 'label' => '完了', 'class'=>''],
    ];

    /**
     * 状態のラベル
     * @return string
     */
    //アクセサ：状態を文字列で表示するためにメソッドを追加
    public function getStatusLabelAttribute()
    {
        // 状態値
        //statusカラムの値を取得し格納
        $status = $this->attributes['status'];
        return self::STATUS[$status]['label'];
    }

    // classについてのアクセサ
    public function getStatusClassAttribute()
    {
        $status = $this->attributes['status'];

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class'];
    }

    // folderテーブルとのリレーション(従属の関係)
    public function folder() // 単数形
    {
        return $this->belongsTo('App\Folder');
    }

    /**
     * 整形した期限日
     * @return string
    */
    // アクセサ：日付の表示を変更
    public function getFormattedDueDateAttribute()
    {
        return $this->attributes['due_date'];
        // return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])->format('Y/m/d');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('Y/m/d');
    }

    public function getProcessImageAttribute()
    {
        $status = $this->attributes['status'];
        if($status == '3'){
            return 'flower';
        }elseif($status == '2'){
            return 'bud';
        }elseif($status == '1'){
            return 'seed';
        }
    }

    public function getCountDownAttribute()
    {
        $today = Carbon::today();
        $due_date = $this->attributes['due_date'];

        $split_due_date = explode('/', $due_date);
        $year = $split_due_date[0];
        $month = $split_due_date[1];
        $day = $split_due_date[2];
        $created_due_date = Carbon::create($year, $month, $day);

        $status = $this->attributes['status'];

        $days = $today->diffInDays($created_due_date);

        if($status == '3'){
            return ' ';
        }else{
            if($today > $created_due_date){
                return '期限切れ！';
            }elseif($today < $created_due_date){
                $days = $today->diffInDays($created_due_date);
                return 'あと'. $days.'日！';
            }elseif($today->isSameDay($created_due_date)){
                return '今日が期限です！';
            }
        }
    }

}
