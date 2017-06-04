<?php

use Illuminate\Database\Seeder;

class VehicleModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_model')->delete();

        $types = array(
            '280ZX' =>  '280ZX',
            '300SZ' =>  '300SZ.',
            'MiTo' =>   'MiTo',
            'Renegade' => 'Renegade',
            '2017 Honda Rebel 300/500'=>'2017 Honda Rebel 300/500',
            '2017 Yamaha SCR 950'=>'2017 Yamaha SCR 950',

        );

        foreach($types as $key => $val) {
            \App\VehicleModel::insert(array(
                'name' => $val,
                'description' => $key,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}
