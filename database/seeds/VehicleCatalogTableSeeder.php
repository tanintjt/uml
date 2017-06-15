<?php

use Illuminate\Database\Seeder;

class VehicleCatalogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_catalog')->delete();


        $vehicle_catalog = array(
            array('1', '1','1','1'),
            array('2', '2','2','2'),
            array('3', '3','3','3'),
            array('1', '4','1','2'),

        );

        foreach($vehicle_catalog as $vc) {
            \App\VehicleCatalog::insert(array(
                'vehicle_type' => $vc[0],
                'vehicle_id' => $vc[1],
                'brand_id' => $vc[2],
                'vehicle_model' => $vc[3],
                'vehicle_image' => Null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}
