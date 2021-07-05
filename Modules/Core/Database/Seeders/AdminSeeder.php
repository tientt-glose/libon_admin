<?php

namespace Modules\Core\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->updateOrInsert(
            [
                [
                    'id_card' => '031731429',
                    'fullname' => 'Nguyen Manh Tien',
                    'email' =>  'admin@admin.com',
                    'password' =>  bcrypt('123456'),
                    'phone' =>  '0945391533',
                    'organization_id' => '1',
                    'career' => '1',
                    'id_staff_student' => '20164069',
                    'admin' =>  '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );
    }
}
