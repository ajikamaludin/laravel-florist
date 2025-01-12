<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class CourierController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Courier::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $query->orderBy('created_at', 'desc');

        return inertia('Courier/Index', [
            'data' => $query->paginate(10),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        Courier::query()->create([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('couriers.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed created']);
    }

    public function update(Request $request, Courier $courier): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        $courier->fill([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        $courier->save();

        return redirect()->route('couriers.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(Courier $courier): RedirectResponse
    {
        $courier->delete();

        return redirect()->route('couriers.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
