<?php

use Illuminate\Database\Seeder;

class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle')->delete();

        $vehicles = array(
            array('1','1', '1','2014','2','Basic Engine Parts','Gasoline'),
            array('2','1', '2','2015','3','Basic Engine Parts','Diesel'),
            array('3','2', '1','2016','2','Basic Engine Parts','Gasoline'),
            array('4','1', '3','2013','4','Basic Engine Parts','Gasoline'),

        );

        foreach($vehicles as $vehicle) {
            \App\Vehicle::insert(array(
                'brand_id' => $vehicle[0],
                'type_id' => $vehicle[1],
                'model_id' => $vehicle[2],
                'production_year' => $vehicle[3],
                'engine_displacement' => $vehicle[4],
                'engine_details' => $vehicle[5],
                'fuel_system' => $vehicle[6],
                'vehicle_image' => Null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}
