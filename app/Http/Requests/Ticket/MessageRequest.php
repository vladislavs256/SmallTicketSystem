<?php

declare(strict_types=1);

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

final class MessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string',
        ];
    }
}
