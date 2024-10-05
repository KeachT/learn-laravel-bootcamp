<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Models\User;
use App\Notifications\NewChirp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChirpCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreated $event): void
    {
        $chirp = $event->chirp;

        $newChirpNotification = new NewChirp($chirp);

        $excludedUserId = $event->chirp->user->id;

        $usersToNotify = User::whereNot('id', $excludedUserId)->cursor();

        foreach ($usersToNotify as $notifiableUser) {
            $notifiableUser->notify($newChirpNotification);
        }
    }
}
