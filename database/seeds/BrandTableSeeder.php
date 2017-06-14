<?php

use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->delete();


        $brands = array(
            array('1', 'SUZUKI'),
            array('1', 'HONDA'),
            array('1', 'NISSAN'),
            array('1', 'KIA' ),
        );

        foreach($brands as $brand) {
            \App\Brand::insert(array(
                'parent_id' => $brand[0],
                'name' => $brand[1],
                'status' => '2',
            ));
        }
    }
}
