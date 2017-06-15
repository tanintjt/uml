<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
        $this->call(VehicleTypeTableSeeder::class);
        $this->call(VehicleModelTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(ServiceCenterTableSeeder::class);
        $this->call(ServicePackageTableSeeder::class);
        $this->call(VehicleTableSeeder::class);
        $this->call(VehicleCatalogTableSeeder::class);

    }
}
