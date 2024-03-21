<?php

namespace Domain\Mail\Actions;

use Domain\Mail\Exceptions\CannotSendBroadcast;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Broadcast;
use Domain\Subscriber\Actions\FilterSubscribersAction;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendBroadcastAction
{
    public static function execute(Broadcast $broadcast): int
    {
        if (!$broadcast->status->canSend()) {
            throw CannotSendBroadcast::because(
                "Broadcast already sent at {$broadcast->sent_at}"
            );
        }

        $subscribers = FilterSubscribersAction::execute($broadcast)
            ->each(
                fn(Subscriber $subscriber) => Mail::to($subscriber)->queue(new EchoMail($broadcast))
            );

        $broadcast->MarkAsSent();

        return $subscribers->each(fn(Subscriber $subscriber) => $broadcast->sent_mails()->create([
            'subscriber_id' => $subscriber->id,
            'user_id'       => $broadcast->user->id,
        ]))->count();
    }
}
