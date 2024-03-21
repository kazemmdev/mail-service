<?php

namespace Domain\Subscriber\ViewModel;

use Domain\Shared\ViewModel\ViewModel;
use Domain\Subscriber\DTOs\FormData;
use Domain\Subscriber\DTOs\SubscriberData;
use Domain\Subscriber\DTOs\TagData;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class UpsertSubscriberViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Subscriber $subscriber = null
    ) {
    }

    public function subscriber(): ?SubscriberData
    {
        if (!$this->subscriber) {
            return null;
        }

        return SubscriberData::from(
            $this->subscriber->load('tags', 'form')
        );
    }

    /**
     * @return Collection<TagData>
     */
    public function tags(): Collection
    {
        return Tag::all()->map(fn(Tag $tag) => TagData::from($tag));
    }

    /**
     * @return Collection<FormData>
     */
    public function forms(): Collection
    {
        return Form::all()->map(fn(Form $form) => FormData::from($form));
    }
}
