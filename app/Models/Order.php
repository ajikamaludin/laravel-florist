<?php

namespace App\Models;

use App\Models\Default\Model;
use App\Models\Default\User;
use App\Models\Traits\HasFile;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFile;

    protected $fillable = [
        'order_customer_id',
        'ship_customer_id',
        'type_flower_id',
        'type_size_id',
        'type_crest_id',
        'store_id',
        'courier_id',
        'status_id',
        'inputed_user_id',
        'flower_image',
        'code',
        'order_date',
        'ship_date',
        'ship_time',
        'body',
        'request_flower_type',
        'item_price',
        'item_qty',
        'builder_name',
        'board_use',
        'time_start',
        'time_done',
        'shiped_time',
        'ship_customer_phone',
        'ship_customer_adress',
        'ship_customer_city',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $date = Carbon::parse($order->order_date);
            $lastest = Order::whereDate('order_date', $date)->orderBy('created_at', 'desc')->value('code');
            $lastest = $lastest != null ? explode('-', $lastest) : [0, 0];
            $saleCount = $lastest[1] + 1;
            $order->code = 'INV/' . $date->format('dmY') . '-' . formatNum($saleCount, 4);
        });
    }

    public function orderCustomer()
    {
        return $this->belongsTo(Customer::class, 'order_customer_id');
    }

    public function shipCustomer()
    {
        return $this->belongsTo(Customer::class, 'ship_customer_id');
    }

    public function typeFlower()
    {
        return $this->belongsTo(TypeFlower::class, 'type_flower_id');
    }

    public function typeSize()
    {
        return $this->belongsTo(TypeSize::class, 'type_size_id');
    }

    public function typeCrest()
    {
        return $this->belongsTo(TypeCrest::class, 'type_crest_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }

    public function status()
    {
        return $this->belongsTo(TypeStatus::class, 'status_id');
    }

    public function inputedUser()
    {
        return $this->belongsTo(User::class, 'inputed_user_id');
    }
}
