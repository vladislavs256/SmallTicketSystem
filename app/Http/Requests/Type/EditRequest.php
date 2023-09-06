<?php

declare(strict_types=1);

namespace App\Http\Requests\Type;

use Illuminate\Foundation\Http\FormRequest;

final class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
