<?php

namespace App\Http\Controllers;

use App\Models\TypeSize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class TypeSizeController extends Controller
{
    public function index(Request $request): Response
    {
        $query = TypeSize::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $query->orderBy('created_at', 'desc');

        return inertia('TypeSize/Index', [
            'data' => $query->paginate(10),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        TypeSize::create([
            'name' => $request->name
        ]);

        return redirect()->route('type-sizes.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed created']);
    }

    public function update(Request $request, TypeSize $typeSize): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $typeSize->fill([
            'name' => $request->name,
        ]);

        $typeSize->save();

        return redirect()->route('type-sizes.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(TypeSize $typeSize): RedirectResponse
    {
        $typeSize->delete();

        return redirect()->route('type-sizes.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
