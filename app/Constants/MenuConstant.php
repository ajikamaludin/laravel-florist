<?php

namespace App\Constants;

use Illuminate\Support\Facades\Route;

class MenuConstant
{
    public static function all()
    {
        $menu = [
            [
                'name' => 'Dashboard',
                'show' => true,
                'icon' => 'HiChartPie',
                'route' => route('dashboard'),
                'active' => 'dashboard',
                'permission' => 'view-dashboard',
            ],
            [
                'name' => 'Order',
                'show' => true,
                'icon' => 'HiClipboardDocumentList',
                'route' => route('orders.index'),
                'active' => 'orders.*',
                'permission' => 'view-order',
            ],
            [
                'name' => 'Customer',
                'show' => true,
                'icon' => 'HiUserGroup',
                'route' => route('customers.index'),
                'active' => 'customers.*',
                'permission' => 'view-customer',
            ],
            [
                'name' => 'Kurir',
                'show' => true,
                'icon' => 'HiTruck',
                'route' => route('couriers.index'),
                'active' => 'couriers.*',
                'permission' => 'view-courier',
            ],
            [
                'name' => 'User',
                'show' => true,
                'icon' => 'HiUser',
                'items' => [
                    [
                        'name' => 'Roles',
                        'show' => true,
                        'route' => route('roles.index'),
                        'active' => 'roles.*',
                        'permission' => 'view-role',
                    ],
                    [
                        'name' => 'Users',
                        'show' => true,
                        'route' => route('user.index'),
                        'active' => 'user.index',
                        'permission' => 'view-user',
                    ],
                ],
            ],
            [
                'name' => 'Setting',
                'show' => true,
                'icon' => 'HiCog',
                'items' => [
                    [
                        'name' => 'General',
                        'show' => true,
                        'route' => route('setting.index'),
                        'active' => 'setting.index',
                        'permission' => 'view-setting',
                    ],
                    [
                        'name' => 'Toko',
                        'show' => true,
                        'route' => route('stores.index'),
                        'active' => 'stores.*',
                        'permission' => 'view-store',
                    ],
                    [
                        'name' => 'Status',
                        'show' => true,
                        'route' => route('type-statuses.index'),
                        'active' => 'type-statuses.*',
                        'permission' => 'view-typeStatus',
                    ],
                    [
                        'name' => 'Jambul',
                        'show' => true,
                        'route' => route('type-crests.index'),
                        'active' => 'type-crests.*',
                        'permission' => 'view-typeCrest',
                    ],
                    [
                        'name' => 'Size',
                        'show' => true,
                        'route' => route('type-sizes.index'),
                        'active' => 'type-sizes.*',
                        'permission' => 'view-typeSize',
                    ],
                    [
                        'name' => 'Jenis Bunga',
                        'show' => true,
                        'route' => route('type-flowers.index'),
                        'active' => 'type-flowers.*',
                        'permission' => 'view-typeFlower',
                    ],
                ]
            ],

            // # Add Generated Menu Here!

        ];

        return $menu;
    }
}
