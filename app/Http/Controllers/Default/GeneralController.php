<?php

namespace App\Http\Controllers\Default;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Default\Role;
use App\Models\Default\User;
use App\Models\Order;
use Illuminate\Support\Facades\Concurrency;

class GeneralController extends Controller
{
    public function index()
    {
        [
            $role_count,
            $user_count,
            $customer_count,
            $order_count,
        ] = Concurrency::run([
            fn() => Role::count(),
            fn() => User::count(),
            fn() => Customer::count(),
            fn() => Order::count(),
        ]);

        return inertia('Dashboard', [
            'role_count' => $role_count,
            'user_count' => $user_count,
            'customer_count' => $customer_count,
            'order_count' => $order_count,
        ]);
    }

    public function maintance()
    {
        return inertia('Maintance');
    }
}
