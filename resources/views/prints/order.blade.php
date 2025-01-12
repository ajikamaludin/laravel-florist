<!DOCTYPE html>
<html lang="en" data-theme="winter">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        {!! Vite::content('resources/css/app.css') !!}
    </style>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <table class="w-full mb-4">
        <tr>
            <td class="font-bold text-2xl text-left">Invoice</td>
            <td>
                {{-- <img src="{{ storage_path('/app/public/'.$setting->getValueByKey('app_logo')) }}" style="width: 200px;" /> --}}
            </td>
        </tr>
        <tr>
            <td class="text-xl text-left">
                {{ $order->code }}
            </td>
            <td></td>
        </tr>
    </table>
    <hr />
    <table>
        <tbody>
            {{-- <tr>
                <td style="width: 300px">Nama Penginput</td>
                <td>: {{ $order->inputedUser->name }}</td>
            </tr>
            <tr>
                <td>Tanggal Pesanan</td>
                <td>: {{ formatDate($order->order_date) }}</td>
            </tr>
            <tr>
                <td>Tanggal Pengiriman & Waktu</td>
                <td>: {{ formatDate($order->ship_date) }} {{ $order->ship_time }}</td>
            </tr>
            <tr>
                <td>Nama Pemesan</td>
                <td>: {{ $order->orderCustomer->name }}</td>
            </tr>
            <tr>
                <td>Nama Penerima</td>
                <td>: {{ $order->shipCustomer->name }}</td>
            </tr>
            <tr>
                <td>No.Telp Penerima</td>
                <td>: {{ $order->ship_customer_phone }}</td>
            </tr>
            <tr>
                <td>Alamat Penerima</td>
                <td>: {{ $order->ship_customer_city }}, {{ $order->ship_customer_adress }}</td>
            </tr> --}}
            <tr>
                <td>Jenis Bunga</td>
                <td>: {{ $order->typeFlower->name }}</td>
            </tr>
            <tr>
                <td>Ukuran</td>
                <td>: {{ $order->typeSize->name }}</td>
            </tr>
            <tr>
                <td>Jumlah Jambul</td>
                <td>: {{ $order->typeCrest->name }}</td>
            </tr>
            <tr>
                <td>Isi Redaksi</td>
                <td>: {{ $order->body }}</td>
            </tr>
            <tr>
                <td>Permintaan Model Bunga</td>
                <td>: {{ $order->request_flower_type }}</td>
            </tr>
            {{-- <tr>
                <td>Toko Pembuat</td>
                <td>: {{ $order->store->name }}</td>
            </tr>
            <tr>
                <td>Nama Perangkai</td>
                <td>: {{ $order->builder_name }}</td>
            </tr>
            <tr>
                <td>Kurir</td>
                <td>: {{ $order->courier->name }}</td>
            </tr>
            <tr>
                <td>Papan digunakan</td>
                <td>: {{ $order->board_use }}</td>
            </tr>
            <tr>
                <td>Waktu Mulai Pembuatan</td>
                <td>: {{ $order->time_start }}</td>
            </tr>
            <tr>
                <td>Waktu Selesai Pembuatan</td>
                <td>: {{ $order->time_done }}</td>
            </tr>
            <tr>
                <td>Waktu Berangkat Pembuatan</td>
                <td>: {{ $order->shiped_time }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: {{ $order->status->name }}</td>
            </tr> --}}
            <tr>
                <td>Harga Satuan</td>
                <td>: {{ formatIDR($order->item_price) }}</td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 50px"/>
    @if(file_exists(storage_path('/app/private/public/' . $order->flower_image)))
        <img src={{ storage_path('/app/private/public/' . $order->flower_image) }} width="100%"/>
    @endif
</body>

</html>
