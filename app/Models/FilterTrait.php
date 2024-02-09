<?php

namespace App\Models;

use App\Http\Requests\ValueObjects\Filter;
use Illuminate\Database\Eloquent\Builder;

trait FilterTrait
{
    public function scopeApplyFilter(Builder $query, array $filters): Builder
    {
        /** @var Filter[] $filters */
        foreach ($filters as $filter) {
            $type = $filter->getType();
            $property = $filter->getProperty();
            $value = $filter->getValue();

            if (method_exists($this, $type)) {
                $query = $this->{$filter->getType()}($query, $property, $value);
            }
        }

        return $query;
    }

    public function partial(Builder $query, string $property, string $value): Builder
    {
        return $query->where($property, 'LIKE', "%$value%");
    }

    public function start(Builder $query, string $property, string $value): Builder
    {
        return $query->where($property, 'LIKE', "$value%");
    }

    public function end(Builder $query, string $property, string $value): Builder
    {
        return $query->where($property, 'LIKE', "%$value");
    }
}
