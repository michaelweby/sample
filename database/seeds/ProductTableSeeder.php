<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<50;$i++){
            DB::table('products')->insert([
                'name'=>'product'.$i,
                'description'=>'description',
                'serial_number'=>'145522'.$i,
                'price'=>rand(10,100),
                'image'=>'',
                'shop_id'=>1,
                'recommendation'=>0,
                'published'=>1,
                'priorty'=>0,
                'quantity'=>rand(0,50),

            ]);
        }
    }
}
