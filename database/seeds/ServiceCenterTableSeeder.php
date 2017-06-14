<?php

use Illuminate\Database\Seeder;

class ServiceCenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_center')->delete();


        $service_center = array(
            array('38.8971470000000000', '-77.0439340000000000','+88-02-8319447','02 Shaheed Tajuddin Ahmed Ave, Dhaka 1208.'),
            array('44.2272390000000000', '4.5649320000000000','+88-02-8319447','23/KA, New Eskaton Road, Moghbazar, Dhaka'),
            array('4.2272390000000000', '21.5649320000000000','+88-02-8319447','102 Shaheed Razzak Ave, Dhaka 1208'),
            array('-96.8032200000000000', '-98.5350600000000000','+88-02-8319447','Uttor Begun Bari Rd, Dhaka 1208
'),

        );

        foreach($service_center as $sc) {
            \App\ServiceCenter::insert(array(
                'latitude' => $sc[0],
                'longitude' => $sc[1],
                'phone' => $sc[2],
                'address' => $sc[3],
                'store_image' => Null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}
