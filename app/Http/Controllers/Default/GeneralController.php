<?php

namespace App\Http\Controllers\Default;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Default\Role;
use App\Models\Default\User;
use App\Models\Order;
use Revolution\Google\Sheets\Facades\Sheets;

class GeneralController extends Controller
{
    public function index()
    {
        $role_count = Role::count();
        $user_count = User::count();
        $customer_count = Customer::count();
        $order_count = Order::count();

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

    public function sheets()
    {
        $sheets = Sheets::spreadsheet(env("SHEET_ID"))
            ->sheet('Order')
            ->get();

        $header = $sheets->pull(0);

        $sheets = Sheets::collection($header, $sheets);

        $order = $sheets->pluck('Nomor Pesanan')->search(1); //0 == 2, maka index + 2

        Sheets::sheet('Order')->range('A' . $order + 2)->update([['3', 'name3', 'mail3']]);
    }
}
