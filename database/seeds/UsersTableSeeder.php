<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i=0;$i<3;$i++){
            DB::table('users')->insert([
                'first_name'=>'admin'.$i,
                'last_name'=>' ',
                'username'=>'admin'.$i,
                'email'=>str_random(10).'@gmail.com',
                'password'=>bcrypt('admin'),
                'type'=>'admin',
                'phone'=>'01'.rand(1,999999999),
            ]);
        }
        for ($i=0;$i<3;$i++){
            DB::table('users')->insert([
                'first_name'=>'vendor'.$i,
                'last_name'=>' ',
                'username'=>'vendor'.$i,
                'email'=>str_random(10).'@gmail.com',
                'password'=>bcrypt('vendor'),
                'type'=>'vendor',
                'phone'=>'01'.rand(1,999999999),
            ]);
        }
        for ($i=0;$i<3;$i++){
            DB::table('users')->insert([
                'first_name'=>'customer'.$i,
                'last_name'=>' ',
                'username'=>'customer'.$i,
                'email'=>str_random(10).'@gmail.com',
                'password'=>bcrypt('customer'),
                'type'=>'customer',
                'phone'=>'01'.rand(1,999999999),
            ]);
        }


        factory(App\User::class, 2)->create()->each(function($u) {
            $u->save();
        });

    }
}
