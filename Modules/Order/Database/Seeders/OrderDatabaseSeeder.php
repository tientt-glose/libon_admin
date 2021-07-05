<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert(
            [
                'user_id' => '2',
                'restore_deadline' => Carbon::now()->addDays(3),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('books_in_orders')->insert([
            [
                'order_id' => '1',
                'the_book_id' => '23',
                'book_id' => '15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'order_id' => '1',
                'the_book_id' => '24',
                'book_id' => '14',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
