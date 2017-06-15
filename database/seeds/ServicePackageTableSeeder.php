<?php

use Illuminate\Database\Seeder;

class ServicePackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_package')->delete();


        $service_package = array(
            array('Change the engine oil', 'Change the engine oil','20'),
            array('Replace the oil filter', 'Replace the oil filter','30'),
            array('Replace the fuel filter', 'Replace the fuel filter','40'),
            array('Tune the engine', 'Tune the engine','50'),

        );

        foreach($service_package as $sp) {
            \App\ServicePackage::insert(array(
                'name' => $sp[0],
                'details' => $sp[1],
                'package_rate' => $sp[2],
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}
