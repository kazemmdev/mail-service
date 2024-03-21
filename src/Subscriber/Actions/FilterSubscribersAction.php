<?php

namespace Domain\Subscriber\Actions;

use Domain\Mail\Models\Broadcast;
use Domain\Subscriber\Enums\Filters;
use Domain\Subscriber\Filters\Filter;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

class FilterSubscribersAction
{
    /**
     * @return Collection<Subscriber> *
     */
    public static function execute(Broadcast $broadcast): Collection
    {
        return app(Pipeline::class)
            ->send(Subscriber::query())->through(self::filters($broadcast))->thenReturn()
            ->get();
    }

    /**
     * @return array<Filter> *
     */
    public static function filters(Broadcast $broadcast): array
    {
        return collect($broadcast->filters->toArray())
            ->map(fn(array $ids, string $key) => Filters::from($key)->createFilter($ids))
            ->values()
            ->all();
    }
}
