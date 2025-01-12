<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\TypeCrest;
use App\Models\TypeFlower;
use App\Models\TypeSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['S', 'M', 'L', 'XL'] as $p) {
            TypeSize::query()->create(['name' => $p]);
        }

        foreach (['Mawar', 'Melati', 'Matahari', 'Tomat'] as $p) {
            TypeFlower::query()->create(['name' => $p]);
        }

        foreach (['1', '2', '3', '4'] as $p) {
            TypeCrest::query()->create(['name' => $p]);
        }

        Customer::query()->create([
            'name' => 'Customer 1',
            'phone' => '0812332112',
            'city' => 'Klaten',
            'address' => 'Alamat Lengkap'
        ]);
    }
}
