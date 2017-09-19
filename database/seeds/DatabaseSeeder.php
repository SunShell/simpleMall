<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        //用户表
        DB::table('users')->insert([
            'userId' => 'admin',
            'name' => '超级管理员',
            'isAdmin' => 1,
            'password' => bcrypt('test'),
            'roleId' => '0',
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
