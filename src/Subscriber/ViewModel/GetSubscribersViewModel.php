<?php

namespace Domain\Subscriber\ViewModel;

use Domain\Shared\ViewModel\ViewModel;
use Domain\Subscriber\DTOs\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class GetSubscribersViewModel extends ViewModel
{
    private const PER_PAGE = 20;

    public function __construct(
        private readonly int $currentPage
    ) {
    }

    // todo: we have use offset and limit on query
    public function subscribers(): Paginator
    {
        /** @var Collection $items * */
        $items = Subscriber::with(['form', 'tags'])
            ->orderBy('first_name')
            ->get()
            ->map(fn(Subscriber $subscriber) => SubscriberData::from($subscriber));

        $items = $items->slice(
            self::PER_PAGE * ($this->currentPage - 1)
        );


        return new Paginator(
            items      : $items,
            perPage    : self::PER_PAGE,
            currentPage: $this->currentPage,
            options    : [

            ]
        );
    }


    public function total(): int
    {
        return Subscriber::count();
    }
}
