<?php

use Illuminate\Database\Seeder;

class VehicleTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        DB::table('vehicle_type')->delete();

        $types = array(
            'Cars' => 'Cars.',
            'Antique/Classic Cars' => 'Antique/Classic Cars.',
            'MotorCycles' => 'MotorCycles.',
            'PowerSports' => 'PowerSports.',
        );

        foreach($types as $key => $val) {
            \App\VehicleType::insert(array(
                'name' => $val,
                'description' => $key,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}
