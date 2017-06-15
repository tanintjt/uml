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
            array('1', '1','2014','2','Basic Engine Parts','Gasoline'),
            array('1', '2','2015','3','Basic Engine Parts','Diesel'),
            array('2', '1','2016','2','Basic Engine Parts','Gasoline'),
            array('1', '3','2013','4','Basic Engine Parts','Gasoline'),

        );

        foreach($vehicles as $vehicle) {
            \App\Vehicle::insert(array(
                'type_id' => $vehicle[0],
                'model_id' => $vehicle[1],
                'production_year' => $vehicle[2],
                'engine_displacement' => $vehicle[3],
                'engine_details' => $vehicle[4],
                'fuel_system' => $vehicle[5],
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}
