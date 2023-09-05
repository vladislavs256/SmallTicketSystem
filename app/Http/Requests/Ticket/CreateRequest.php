<?php
declare(strict_types=1);

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

final class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|int',
            'attachments.*' => 'nullable|file|max:5120',
        ];
    }
}
