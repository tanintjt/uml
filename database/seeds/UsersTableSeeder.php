<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->delete();

        $users = array(
            array('sp-admin', 'sp.admin@gmail.com','$2y$10$wtqhv7P5EmDVR0YKW8VZwObLRLpwTrenhI3IVN1UDzCv5nWNtl8W6','8845454788','uml','$2y$10$K1IhJrBrfjt2hR29H522OOtG2o1eXMsgCrqvJB4KImXtogr34nwJC','1','MbF5UzLUSZ11mDaazyMV6Fq1Lbfs08V62ukA9WlEDMA4iAizKyBfOzr5PLea','Idha2q8a8Tx5eBUcGdRzVsilU9of2q'),
            array('admin', 'admin@admin.com','$2y$10$T8UiaKItGJgSHK9AA.ZtYuKtaEnEWbmy/eqQBZkISLZjOWbdE8qHS','5656766787','uml','$2y$10$N60KomSSMhJFGvznayTZDufVuFDvz3L3W4/7OJGeaYR8poYO2brHq','1','QfwzwjnKsWhaHAS8Iy0vk7V2ze6UPKdLHkQycl8sGu6H9gYesRGLXacdTnwz','Idha2q8a8Tx5eBUcGdRzVsilU9of2i'),


        );

        foreach($users as $user) {
            \App\User::insert(array(
                'name' => $user[0],
                'email' => $user[1],
                'password' => $user[2],
                'phone' => $user[3],
                'provider' => $user[4],
                'provider_id' => $user[5],
                'status' => $user[6],
                'api_token' => $user[7],
                'remember_token' => $user[8],
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ));
        }
    }
}
