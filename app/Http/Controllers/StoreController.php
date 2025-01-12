<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Services\SheetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class StoreController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Store::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $query->orderBy('created_at', 'desc');

        return inertia('Store/Index', [
            'data' => $query->paginate(10),
        ]);
    }


    /** @disregard */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Store::query()->create([
            'name' => $request->name,
            'city' => $request->city,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        try {
            SheetService::store()->append([[$request->name, $request->city, $request->phone, $request->address]]);
        } catch (\Exception $e) {
            info('error', [$e->getMessage()]);
        }
        return redirect()->route('stores.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed created']);
    }

    public function update(Request $request, Store $store): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $key = $store->name;
        $store->fill([
            'name' => $request->name,
            'city' => $request->city,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $store->save();

        try {
            SheetService::update_store($key, [$request->name, $request->city, $request->phone, $request->address]);
        } catch (\Exception $e) {
            info('error', [$e->getMessage()]);
        }

        return redirect()->route('stores.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(Store $store): RedirectResponse
    {
        if ($store->users()->count() > 0) {
            return redirect()->route('stores.index')
                ->with('message', ['type' => 'error', 'message' => 'Tidak dapat menghapus toko yang memiliki users']);
        }

        try {
            SheetService::delete_store($store->name);
        } catch (\Exception $e) {
            info('error', [$e->getMessage()]);
        }

        $store->delete();

        return redirect()->route('stores.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
