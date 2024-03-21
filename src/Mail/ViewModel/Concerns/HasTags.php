<?php

namespace Domain\Mail\ViewModel\Concerns;

use Domain\Subscriber\DTOs\TagData;
use Domain\Subscriber\Models\Tag;
use Illuminate\Support\Collection;

trait HasTags
{
    /**
     * @return Collection<TagData>
     */
    public function tags(): Collection
    {
        return Tag::all()->map->getData();
    }
}
