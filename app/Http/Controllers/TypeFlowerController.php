<?php

namespace App\Http\Controllers;

use App\Models\TypeFlower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class TypeFlowerController extends Controller
{
    public function index(Request $request): Response
    {
        $query = TypeFlower::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $query->orderBy('created_at', 'desc');

        return inertia('TypeFlower/Index', [
            'data' => $query->paginate(10),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        TypeFlower::create([
            'name' => $request->name
        ]);

        return redirect()->route('type-flowers.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed created']);
    }

    public function update(Request $request, TypeFlower $typeFlower): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $typeFlower->fill([
            'name' => $request->name,
        ]);

        $typeFlower->save();

        return redirect()->route('type-flowers.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(TypeFlower $typeFlower): RedirectResponse
    {
        $typeFlower->delete();

        return redirect()->route('type-flowers.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
