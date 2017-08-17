<?php

namespace App\Notifications;

use Illuminate\Contracts\Mail\Mailer;

class SendActivationEmail
{
    protected $mailer;

    /**
     * from email address
     * @var string
     */
    protected $fromAddress = 'uttara.motors.bd@gmail.com';

    /**
     * from name
     * @var string
     */
    protected $fromName = 'Uttara Motors Smart Service';

    /**
     * email to send to
     * @var [type]
     */
    protected $to;

    /**
     * Subject of the email
     * @var [type]
     */
    protected $subject;

    /**
     * view template for email
     * @var [type]
     */
    protected $view;

    /**
     * data to be sent alone email
     * @var array
     */
    protected $data = [];


    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send Ticket information to user
     *
     * @param  User   $user
     * @param  Activation  $activation
     * @return method deliver()
     */
    public function sendActivation($user, $activation)
    {

        /*$link = route('auth.activation', $activation->token);
        $message = sprintf('Activate account %s', $link, $link);
        $this->mailer->raw($message, function (Message $m) use ($user) {
            $m->to($user->email)->subject('Verify your email address');
        });*/

        $this->to = $user->email;
        $this->subject = "Verify your email address";
        $this->view = 'emails.activation';
        $this->data = compact('user', 'activation');

        return $this->deliver();
    }

    /**
     * Do the actual sending of the mail
     */
    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function($message) {
            $message->from($this->fromAddress, $this->fromName)
                ->to($this->to)->subject($this->subject);
        });
    }
}
