<?php

namespace Domain\Mail\ViewModel;

use Domain\Mail\DTOs\BroadcastData;
use Domain\Mail\Models\Broadcast;
use Domain\Mail\ViewModel\Concerns\HasForms;
use Domain\Mail\ViewModel\Concerns\HasTags;
use Domain\Shared\ViewModel\ViewModel;

class UpsertBroadcastViewModel extends ViewModel
{
    use HasTags;
    use HasForms;

    public function __construct(
        public readonly ?Broadcast $broadcast = null
    ) {
    }

    public function broadcast(): ?BroadcastData
    {
        if (!$this->broadcast) {
            return null;
        }
        return $this->broadcast->getData();
    }
}
