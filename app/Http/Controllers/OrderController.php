<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Rules\IndonesiaPhoneNumber;
use App\Rules\Time;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Order::query()->with(['store', 'shipCustomer', 'status']);

        if ($request->q) {
            $query->where('code', 'like', "%{$request->q}%");
        }

        $user = $request->user();

        if (!$user->can('view-order-all')) {
            $query->where('store_id', $user->store_id);
        }

        $query->orderBy('created_at', 'desc');

        return inertia('Order/Index', [
            'data' => $query->paginate(20),
        ]);
    }

    public function create(): Response
    {
        return inertia('Order/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'inputed_user_id' => 'required|exists:users,id',
            'order_date' => 'required|date',
            'ship_date' => 'required|date',
            'ship_time' => ['required', new Time],
            'order_customer_id' => 'required|exists:customers,id',
            'ship_customer_id' => 'required|exists:customers,id',
            'phone_ship_customer' => ['required', new IndonesiaPhoneNumber],
            'address_ship_customer' => 'required|string',
            'city_ship_customer' => 'required|string',
            'type_flower_id' => 'required|exists:type_flowers,id',
            'type_size_id' => 'required|exists:type_sizes,id',
            'type_crest_id' => 'required|exists:type_crests,id',
            'body' => 'required|string',
            'request_flower_type' => 'required|string',
            'item_price' => 'nullable|numeric',
            'item_qty' => 'nullable|numeric',
            'flower_image' => 'nullable|string',
            'store_id' => 'required|exists:stores,id',
            'courier_id' => 'required|exists:couriers,id',
            'builder_name' => 'nullable|string',
            'board_use' => 'nullable|string',
            'time_start' =>  ['nullable', new Time],
            'time_done' =>  ['nullable', new Time],
            'shiped_time' =>  ['nullable', new Time],
            'status_id' => 'required|exists:type_statuses,id',
        ]);

        Order::query()->create([
            'order_customer_id' => $request->order_customer_id,
            'ship_customer_id' => $request->ship_customer_id,
            'type_flower_id' => $request->type_flower_id,
            'type_size_id' => $request->type_size_id,
            'type_crest_id' => $request->type_crest_id,
            'store_id' => $request->store_id,
            'courier_id' => $request->courier_id,
            'status_id' => $request->status_id,
            'inputed_user_id' => $request->inputed_user_id,
            'flower_image' => $request->flower_image,
            'order_date' => $request->order_date,
            'ship_date' => $request->ship_date,
            'ship_time' => $request->ship_time,
            'body' => $request->body,
            'request_flower_type' => $request->request_flower_type,
            'item_price' => $request->item_price,
            'item_qty' => $request->item_qty,
            'builder_name' => $request->builder_name,
            'board_use' => $request->board_use,
            'time_start' => $request->time_start,
            'time_done' => $request->time_done,
            'shiped_time' => $request->shiped_time,
            'ship_customer_phone' => $request->phone_ship_customer,
            'ship_customer_adress' => $request->address_ship_customer,
            'ship_customer_city' => $request->city_ship_customer,
        ]);

        return redirect()->route('orders.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed created']);
    }

    public function show(Order $order): Response
    {
        return inertia('Order/Show', [
            'order' => $order->load([
                'orderCustomer',
                'shipCustomer',
                'typeFlower',
                'typeSize',
                'typeCrest',
                'store',
                'courier',
                'status',
                'inputedUser'
            ]),
        ]);
    }

    public function edit(Order $order): Response
    {
        return inertia('Order/Form', [
            'order' => $order->load([
                'orderCustomer',
                'shipCustomer',
                'typeFlower',
                'typeSize',
                'typeCrest',
                'store',
                'courier',
                'status',
                'inputedUser'
            ]),
        ]);
    }


    public function update(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'inputed_user_id' => 'required|exists:users,id',
            'order_date' => 'required|date',
            'ship_date' => 'required|date',
            'ship_time' => ['required', new Time],
            'order_customer_id' => 'required|exists:customers,id',
            'ship_customer_id' => 'required|exists:customers,id',
            'phone_ship_customer' => ['required', new IndonesiaPhoneNumber],
            'address_ship_customer' => 'required|string',
            'city_ship_customer' => 'required|string',
            'type_flower_id' => 'required|exists:type_flowers,id',
            'type_size_id' => 'required|exists:type_sizes,id',
            'type_crest_id' => 'required|exists:type_crests,id',
            'body' => 'required|string',
            'request_flower_type' => 'required|string',
            'item_price' => 'nullable|numeric',
            'item_qty' => 'nullable|numeric',
            'flower_image' => 'nullable|string',
            'store_id' => 'required|exists:stores,id',
            'courier_id' => 'required|exists:couriers,id',
            'builder_name' => 'nullable|string',
            'board_use' => 'nullable|string',
            'time_start' =>  ['nullable', new Time],
            'time_done' =>  ['nullable', new Time],
            'shiped_time' =>  ['nullable', new Time],
            'status_id' => 'required|exists:type_statuses,id',
        ]);

        $order->fill([
            'order_customer_id' => $request->order_customer_id,
            'ship_customer_id' => $request->ship_customer_id,
            'type_flower_id' => $request->type_flower_id,
            'type_size_id' => $request->type_size_id,
            'type_crest_id' => $request->type_crest_id,
            'store_id' => $request->store_id,
            'courier_id' => $request->courier_id,
            'status_id' => $request->status_id,
            'inputed_user_id' => $request->inputed_user_id,
            'flower_image' => $request->flower_image,
            'order_date' => $request->order_date,
            'ship_date' => $request->ship_date,
            'ship_time' => $request->ship_time,
            'body' => $request->body,
            'request_flower_type' => $request->request_flower_type,
            'item_price' => $request->item_price,
            'item_qty' => $request->item_qty,
            'builder_name' => $request->builder_name,
            'board_use' => $request->board_use,
            'time_start' => $request->time_start,
            'time_done' => $request->time_done,
            'shiped_time' => $request->shiped_time,
            'ship_customer_phone' => $request->phone_ship_customer,
            'ship_customer_adress' => $request->address_ship_customer,
            'ship_customer_city' => $request->city_ship_customer,
        ]);

        $order->save();

        return redirect()->route('orders.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }

    public function print(Order $order)
    {
        $pdf = Pdf::loadView('prints/order', [
            'order' => $order->load([
                'orderCustomer',
                'shipCustomer',
                'typeFlower',
                'typeSize',
                'typeCrest',
                'store',
                'courier',
                'status',
                'inputedUser'
            ]),
        ])->setPaper('a4');

        return $pdf->stream();

        // return view('prints/order', [
        //     'order' => $order->load([
        //         'orderCustomer',
        //         'shipCustomer',
        //         'typeFlower',
        //         'typeSize',
        //         'typeCrest',
        //         'store',
        //         'courier',
        //         'status',
        //         'inputedUser'
        //     ]),
        // ]);
    }
}
