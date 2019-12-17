<?php

namespace App;


use App\Repositories\ActivationRepository;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class ActivationService
{

    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;

    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMail($user)
    {

        if (!$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        $link = route('user.activate', $token);
        //$message = __('auth.thanks_for_register')."\n".__('auth.active_by_link').": ".$link;
        $username = $user->name;
        $this->mailer->send(['html' => 'emails.active'], compact('username', 'link'), function (Message $m) use ($user) {
            $m->to($user->email)->subject(__('auth.activation_account'));
        });


    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);

        $user->actived = 1;

        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;

    }

    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();//tg cua ma chua qua 24h
    }

}