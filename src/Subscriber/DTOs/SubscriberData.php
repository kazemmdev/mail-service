<?php

namespace Domain\Subscriber\DTOs;

use Carbon\Carbon;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Tag;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class SubscriberData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $email,
        public readonly string $first_name,
        public readonly ?string $last_name,
        public readonly ?Carbon $subscribed_at,

        /** @var DataCollection<TagData> */
        public readonly ?DataCollection $tags,
        public readonly ?FormData $form,
    ) {
    }

    public static function rules(): array
    {
        return [
            'email'      => ["required", "email", Rule::unique('subscribes', 'email')->ignore('subscriber')],
            'first_name' => "required|string",
            'last_name'  => "required|string",
            'tag_ids'    => "nullable|sometimes|array",
            'form_id'    => "nullable|sometimes|exists:forms,id",
        ];
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
            'tags' => TagData::collect(
                Tag::query()->whereIn('id', $request->collect('tag_ids'))->get()
            ),
            'form' => FormData::from(
                Form::query()->findOrNew($request->form_id)
            )
        ]);
    }
}
