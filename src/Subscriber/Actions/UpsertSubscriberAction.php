<?php

namespace Domain\Subscriber\Actions;

use Domain\Shared\Models\User;
use Domain\Subscriber\DTOs\SubscriberData;
use Domain\Subscriber\Models\Subscriber;

class UpsertSubscriberAction
{
    public static function execute(SubscriberData $data, User $user): Subscriber
    {
        $subscriber = Subscriber::query()->updateOrCreate([
            [
                'id' => $data->id
            ],
            [
                ...$data->all(),
                'form_id' => $data->form?->id,
                'user_id' => $user->id
            ]
        ]);

        $subscriber->tags()->sync(
            $data->tags->toCollection()->pluck('id')
        );

        return $subscriber->load('tags' . 'form');
    }

}
