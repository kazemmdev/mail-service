<?php

namespace Domain\Mail\Actions;

use Domain\Mail\DTOs\BroadcastData;
use Domain\Mail\Models\Broadcast;
use Domain\Shared\Models\User;

class UpsertBroadcastAction
{
    public static function execute(
        BroadcastData $data,
        User $user
    ): Broadcast {
        return Broadcast::updateOrCreate(
            [
                'id' => $data->id,
            ],
            [
                'user_id' => $user->id,
            ],
        );
    }
}
