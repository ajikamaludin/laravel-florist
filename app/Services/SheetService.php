<?php

namespace App\Services;

use Revolution\Google\Sheets\Facades\Sheets;

class SheetService
{
    public static function order()
    {
        return Sheets::spreadsheet(env("SHEET_ID"))->sheet('Order');
    }

    public static function store()
    {
        return Sheets::spreadsheet(env("SHEET_ID"))->sheet('Toko');
    }

    public static function update_store($key, $data)
    {
        $sheets = Sheets::spreadsheet(env("SHEET_ID"))->sheet('Toko')->get();

        $header = $sheets->pull(0);

        $sheets = Sheets::collection($header, $sheets);

        $store = $sheets->pluck('Nama')->search($key); //0 == 2, maka index + 2

        Sheets::sheet('Toko')->range('A' . $store + 2)->update([$data]);
    }

    public static function delete_store($key)
    {
        $sheets = Sheets::spreadsheet(env("SHEET_ID"))->sheet('Toko')->get();

        $header = $sheets->pull(0);

        $sheets = Sheets::collection($header, $sheets);

        $store = $sheets->pluck('Nama')->search($key); //0 == 2, maka index + 2

        Sheets::sheet('Toko')->range('A' . $store + 2 . ':Z' . $store + 2)->clear();
    }

    public static function update_order($key, $data)
    {
        $sheets = Sheets::spreadsheet(env("SHEET_ID"))->sheet('Order')->get();

        $header = $sheets->pull(0);

        $sheets = Sheets::collection($header, $sheets);

        $store = $sheets->pluck('Nomor Pesanan')->search($key); //0 == 2, maka index + 2

        Sheets::sheet('Order')->range('A' . $store + 2)->update([$data]);
    }

    public static function delete_order($key)
    {
        $sheets = Sheets::spreadsheet(env("SHEET_ID"))->sheet('Order')->get();

        $header = $sheets->pull(0);

        $sheets = Sheets::collection($header, $sheets);

        $store = $sheets->pluck('Nomor Pesanan')->search($key); //0 == 2, maka index + 2

        Sheets::sheet('Order')->range('A' . $store + 2 . ':Z' . $store + 2)->clear();
    }
}
