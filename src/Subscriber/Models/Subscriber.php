<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Spatie\LaravelData\WithData;

/**
 * @property string $first_name
 * @property string $last_name
 */
class Subscriber extends BaseModel
{
    use Notifiable;
    use WithData;
    use HasUser;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'form_id',
        'user_id',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function form(): BelongsTo
    {
        // Laravel will return an empty Form object instead of null
        return $this->belongsTo(Form::class)->withDefault();
    }

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn() => "{$this->first_name} {$this->last_name}"
        );
    }
}
