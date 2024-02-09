<?php

namespace App\Http\Requests;

use App\Http\Requests\ValueObjects\Filter;
use Illuminate\Foundation\Http\FormRequest;

class IndexPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['array'],
            'content' => ['array'],
        ];
    }

    public function filters(): array
    {
        $filters = $this->validated();
        $filtersObjects = [];

        foreach ($filters as $property => $filter) {
            foreach ($filter as $type => $value) {
                $filtersObjects[] = new Filter($property, $type, $value);
            }
        }

        return $filtersObjects;
    }
}
