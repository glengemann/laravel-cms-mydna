<?php

namespace App\Http\Requests\ValueObjects;

class Filter
{
    public function __construct(
        public string $property,
        public string $type,
        public string $value,
    ) {
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
