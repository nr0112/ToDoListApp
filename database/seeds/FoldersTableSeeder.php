<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // firstメソッドでユーザーを一行だけ取得、そのidを下でuser_idの値に格納
        $user = DB::table('users')->first();

        $titles = ['プライベート', '仕事', '旅行'];

        foreach($titles as $title){
            DB::table('folders')->insert([
                'title' => $title,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
