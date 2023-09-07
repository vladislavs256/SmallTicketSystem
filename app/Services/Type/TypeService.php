<?php

declare(strict_types=1);

namespace App\Services\Type;

use App\Http\Requests\Type\CreateRequest;
use App\Http\Requests\Type\EditRequest;
use App\Models\Tickets\Type;

class TypeService
{
    public function create(CreateRequest $request): Type
    {

        $type = Type::new(
            $request['name']
        );

        return $type;
    }

    public function edit(int $id, EditRequest $request): void
    {
        $ticket = $this->getType($id);
        $ticket->edit(
            $request['name'],
        );
    }

    public function removeByAdmin(int $id): void
    {
        $type = $this->getType($id);
        $type->delete();
    }

    private function getType($id): Type
    {
        return Type::findOrFail($id);
    }
}
