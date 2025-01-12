<?php

namespace App\Http\Controllers;

use App\Models\TypeCrest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class TypeCrestController extends Controller
{
    public function index(Request $request): Response
    {
        $query = TypeCrest::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $query->orderBy('created_at', 'desc');

        return inertia('TypeCrest/Index', [
            'data' => $query->paginate(10),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        TypeCrest::create([
            'name' => $request->name
        ]);

        return redirect()->route('type-crests.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed created']);
    }

    public function update(Request $request, TypeCrest $typeCrest): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $typeCrest->fill([
            'name' => $request->name,
        ]);

        $typeCrest->save();

        return redirect()->route('type-crests.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(TypeCrest $typeCrest): RedirectResponse
    {
        $typeCrest->delete();

        return redirect()->route('type-crests.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
