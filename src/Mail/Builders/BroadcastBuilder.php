<?php

namespace Domain\Mail\Builders;

use Domain\Mail\Enums\BroadcastStatus;
use Illuminate\Database\Query\Builder;

class BroadcastBuilder extends Builder
{
    public function markAsSent(): void
    {
        $this->model->status  = BroadcastStatus::Sent;
        $this->model->sent_at = now();
        $this->model->save();
    }

}
