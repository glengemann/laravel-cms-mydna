<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->route('status'),
        ]);
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'in:pending,approved,rejected'],
        ];
    }

    public function getStatus(): string
    {
        return dd($this->route('status'));
    }
}
