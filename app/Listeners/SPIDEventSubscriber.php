<?php

namespace App\Listeners;

use App\Models\User;
use Italia\SPIDAuth\Events\LoginEvent;
use Italia\SPIDAuth\Events\LogoutEvent;

class SPIDEventSubscriber
{
    /**
     * Handle SPID login events.
     * @param LoginEvent $event
     */
    public function onSPIDLogin(LoginEvent $event) {
        auth()->logout();
        $SPIDUser = $event->getSPIDUser();
        $user = User::findByFiscalNumber($SPIDUser->fiscalNumber);
        if (isset($user)) {
            auth()->login($user);

            logger()->info('User '.$user->getInfo().' logged in.');
        }
    }

    /**
     * Handle SPID logout events.
     * @param LogoutEvent $event
     */
    public function onSPIDLogout(LogoutEvent $event) {
        if (auth()->check()) {
            $user = auth()->user();

            logger()->info('User '.$user->getInfo().' logged out.');

            session()->invalidate();
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Italia\SPIDAuth\Events\LoginEvent',
            'App\Listeners\SPIDEventSubscriber@onSPIDLogin'
        );

        $events->listen(
            'Italia\SPIDAuth\Events\LogoutEvent',
            'App\Listeners\SPIDEventSubscriber@onSPIDLogout'
        );
    }

}
