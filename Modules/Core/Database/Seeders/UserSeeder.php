<?php

namespace Modules\Core\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'id_card' => '031970067',
                    'fullname' => 'Nguyen Manh Tien',
                    'email' =>  'tiennguyenbka198@gmail.com',
                    'password' =>  bcrypt('123456'),
                    'phone' =>  '0945391533',
                    'organization_id' => '1',
                    'career' => '1',
                    'id_staff_student' => '20164068',
                    'referral_source' => '1',
                    'admin' =>  '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id_card' => '031222333',
                    'fullname' => 'Nguyen Trong Nghia',
                    'email' =>  'tonytit@gmail.com',
                    'password' =>  bcrypt('123456'),
                    'phone' =>  '0945391222',
                    'organization_id' => '1',
                    'career' => '1',
                    'id_staff_student' => '20164000',
                    'referral_source' => '1',
                    'admin' =>  '0',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );

        DB::table('group_user')->updateOrInsert(
            [
                [
                    'user_id' => 2,
                    'group_id' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'user_id' => 3,
                    'group_id' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );

        DB::table('role_user')->updateOrInsert(
            [
                [
                    'user_id' => 2,
                    'role_id' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'user_id' => 3,
                    'role_id' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );
    }
}
