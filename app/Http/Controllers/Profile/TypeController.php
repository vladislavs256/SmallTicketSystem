<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Type\CreateRequest;
use App\Http\Requests\Type\EditRequest;
use App\Models\Tickets\Type;
use App\Services\Type\TypeService;

final class TypeController extends Controller
{
    public function __construct(
        private TypeService $service
    ) {
        $this->middleware('can:manage-tickets');
    }

    public function index()
    {
        $types = Type::all();

        return view('type.index', ['types' => $types]);
    }

    public function create()
    {
        return view('type.create');
    }

    public function editForm(Type $type)
    {
        return view('type.edit', ['type' => $type]);
    }

    public function edit(EditRequest $request, Type $type)
    {
        try {
            $this->service->edit($type->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('type.index', $type);
    }

    public function delete(Type $type)
    {
        try {
            $this->service->removeByAdmin($type->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('type.index');
    }

    public function store(CreateRequest $request)
    {
        try {
            $type = $this->service->create($request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('type.index', $type);
    }
}
