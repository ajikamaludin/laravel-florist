<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Rules\IndonesiaPhoneNumber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class CustomerController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Customer::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $query->orderBy('created_at', 'desc');

        return inertia('Customer/Index', [
            'data' => $query->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string',
            'phone' => ['nullable', new IndonesiaPhoneNumber],
            'address' => 'nullable|string',
        ]);

        $customer = Customer::query()->create([
            'name' => $request->name,
            'city' => $request->city,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        session()->flash('message', ['type' => 'success', 'message' => 'Customer has beed created']);
        session()->flash('data', ['customer' => $customer]);
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string',
            'phone' => ['nullable', new IndonesiaPhoneNumber],
            'address' => 'nullable|string',
        ]);

        $customer->fill([
            'name' => $request->name,
            'city' => $request->city,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $customer->save();

        return redirect()->route('customers.index')
            ->with('message', ['type' => 'success', 'message' => 'Customer has beed updated']);
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('message', ['type' => 'success', 'message' => 'Customer has beed deleted']);
    }
}
