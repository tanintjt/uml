<?php
namespace App\Logic\Activation;

use App\Activation;
use App\User;

class ActivationRepository
{

    public function createTokenAndSendEmail(User $user)
    {

        /*if ($user->status) { //if user changed activated email to new one

            $user->update([
                'status' => 2
            ]);

        }*/

        // Create new Activation record for this user/email
        $activation = new Activation;
        $activation->user_id = $user->id;
        $activation->token = str_random(64);
        $activation->save();

        // Send activation email notification


    }

}