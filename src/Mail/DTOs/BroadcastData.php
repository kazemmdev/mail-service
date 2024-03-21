<?php

namespace Domain\Mail\DTOs;

use Carbon\Carbon;
use Domain\Mail\Enums\BroadcastStatus;
use Spatie\LaravelData\Data;

class BroadcastData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $subject,
        public readonly string $content,
        public readonly ?FilterData $filters,
        public readonly ?Carbon $sent_at,

        public readonly ?BroadcastStatus $status = BroadcastStatus::Draft,
    ) {
    }
}
