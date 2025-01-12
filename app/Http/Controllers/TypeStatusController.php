<?php

namespace App\Http\Controllers;

use App\Models\TypeStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class TypeStatusController extends Controller
{
    public function index(Request $request): Response
    {
        $query = TypeStatus::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $query->orderBy('created_at', 'desc');

        return inertia('TypeStatus/Index', [
            'data' => $query->paginate(10),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        TypeStatus::create([
            'name' => $request->name
        ]);

        return redirect()->route('type-statuses.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed created']);
    }

    public function update(Request $request, TypeStatus $typeStatus): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $typeStatus->fill([
            'name' => $request->name,
        ]);

        $typeStatus->save();

        return redirect()->route('type-statuses.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(TypeStatus $typeStatus): RedirectResponse
    {
        $typeStatus->delete();

        return redirect()->route('type-statuses.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
