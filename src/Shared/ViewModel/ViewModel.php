<?php

namespace Domain\Shared\ViewModel;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use Reflection;

abstract class ViewModel implements Arrayable
{
    public function toArray(): array
    {
        return collect((new ReflectionClass($this))->getMethods())
            ->reject(
                fn(ReflectionMethod $method) => in_array($method->getName(), ['_construct', 'toArray'])
            )
            ->filter(
                fn(ReflectionMethod $method) => in_array('public', Reflection::getModifierNames($method->getModifiers()))
            )
            ->mapWithKeys(
                fn(ReflectionMethod $method) => [
                    Str::snake($method->getName()) => $this->{$method->getName()}()
                ]
            )
            ->toArray();
    }
}
