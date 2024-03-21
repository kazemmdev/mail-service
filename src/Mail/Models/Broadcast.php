<?php

namespace Domain\Mail\Models;

use Domain\Mail\Builders\BroadcastBuilder;
use Domain\Mail\DTOs\BroadcastData;
use Domain\Mail\DTOs\FilterData;
use Domain\Mail\Enums\BroadcastStatus;
use Domain\Mail\Models\Casts\FiltersCast;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\LaravelData\WithData;

/**
 * @property User $user
 *
 * @method MarkAsSent()
 */
class Broadcast extends BaseModel
{
    use WithData;
    use HasUser;

    protected $dataClass = BroadcastData::class;

    protected $casts = [
        'filters' => FiltersCast::class,
        'status'  => BroadcastStatus::class,
    ];
    protected $attributes = [
        'status' => BroadcastStatus::Draft,
    ];

    public function filters(): Attribute
    {
        return new Attribute(
            get: fn(string $value) => FilterData::from(
                json_decode($value, true)
            ),
            set: fn(FilterData $value) => json_encode($value),
        );
    }


    public function newEloquentBuilder($query): BroadcastBuilder
    {
        return new BroadcastBuilder($query);
    }
}
