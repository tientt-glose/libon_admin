<?php

namespace Modules\Book\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insertOrIgnore([
            [
                'content' => 'Binh luan hien thi, chua xoa',
                'user_id' => 10,
                'book_id' => 17,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'content' => 'Binh luan ko hien thi, da xoa',
                'user_id' => 9,
                'book_id' => 16,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now()
            ]
        ]);
    }
}
