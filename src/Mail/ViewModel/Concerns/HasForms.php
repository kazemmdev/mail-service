<?php

namespace Domain\Mail\ViewModel\Concerns;

use Domain\Subscriber\DTOs\FormData;
use Domain\Subscriber\Models\Form;
use Illuminate\Support\Collection;

trait HasForms
{
    /**
     * @return Collection<FormData>
     */
    public function forms(): Collection
    {
        return Form::all()->map->getData();
    }
}
