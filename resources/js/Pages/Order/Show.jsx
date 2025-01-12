import React, { useEffect, useState } from 'react'
import { router, Head, Link, usePage } from '@inertiajs/react'
import { isEmpty } from 'lodash'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import TextInput from '@/Components/DaisyUI/TextInput'
import Button from '@/Components/DaisyUI/Button'
import Card from '@/Components/DaisyUI/Card'
import SelectModalInput from '@/Components/DaisyUI/SelectModalInput'
import TextareaInput from '@/Components/DaisyUI/TextareaInput'
import { formatDate, formatIDR } from '@/utils'
import ImageModal from './ImageModal'
import CustomerFormModal from '../Customer/FormModal'
import { useModalState } from '@/hooks'
import HasPermission from '@/Components/Common/HasPermission'

export default function Form(props) {
    const {
        props: { errors, auth },
    } = usePage()
    const { order } = props

    const [processing, setProcessing] = useState(false)
    const customerModal = useModalState()

    const [inputed_user, setInputedUser] = useState(auth.user)
    const [order_date, setOrderDate] = useState(new Date())
    const [ship_date, setShipDate] = useState(new Date())
    const [ship_time, setShipTime] = useState('')
    const [order_customer, setOrderCustomer] = useState(null)
    const [ship_customer, setShipCustomer] = useState(null)
    const [phone_ship_customer, setPhoneShipCustomer] = useState('')
    const [address_ship_customer, setAddressShipCustomer] = useState('')
    const [city_ship_customer, setCityShipCustomer] = useState('')
    const [type_flower, setTypeFlower] = useState(null)
    const [type_size, setTypeSize] = useState(null)
    const [type_crest, setTypeCrest] = useState(null)
    const [body, setBody] = useState('')
    const [request_flower_type, setRequestFlowerType] = useState('')
    const [item_price, setItemPrice] = useState('')
    const [item_qty, setItemQty] = useState('')
    const [flower_image, setFlowerImage] = useState('')
    const [store, setStore] = useState(null)
    const [courier, setCourier] = useState(null)
    const [builder_name, setBuilderName] = useState('')
    const [board_use, setBoardUse] = useState('')
    const [time_start, setTimeStart] = useState('')
    const [time_done, setTimeDone] = useState('')
    const [shiped_time, setShipedTime] = useState('')
    const [status, setStatus] = useState(null)

    const handleShipCustomer = (item) => {
        setShipCustomer(item)
        setPhoneShipCustomer(item.phone ?? '')
        setCityShipCustomer(item.city ?? '')
        setAddressShipCustomer(item.address ?? '')
    }

    const toggleFormCustomer = (callback) => {
        console.log(callback)
        customerModal.setMetadata(callback)
        customerModal.toggle()
    }

    const handleCustomerCreated = (item) => {
        if (customerModal.metadata === 'ship') {
            handleShipCustomer(item)
        }
        if (customerModal.metadata === 'order') {
            setOrderCustomer(item)
        }
    }

    const handleSubmit = () => {
        const payload = {
            inputed_user_id: inputed_user?.id,
            order_date: order_date,
            ship_date: ship_date,
            ship_time: ship_time,
            order_customer_id: order_customer?.id,
            ship_customer_id: ship_customer?.id,
            phone_ship_customer: phone_ship_customer,
            address_ship_customer: address_ship_customer,
            city_ship_customer: city_ship_customer,
            type_flower_id: type_flower?.id,
            type_size_id: type_size?.id,
            type_crest_id: type_crest?.id,
            body: body,
            request_flower_type: request_flower_type,
            item_price: item_price,
            item_qty: item_qty,
            flower_image: flower_image,
            store_id: store?.id,
            courier_id: courier?.id,
            builder_name: builder_name,
            board_use: board_use,
            time_start: time_start,
            time_done: time_done,
            shiped_time: shiped_time,
            status_id: status?.id,
        }

        if (isEmpty(order) === false) {
            router.put(route('orders.update', order), payload, {
                onStart: () => setProcessing(true),
                onFinish: (e) => {
                    setProcessing(false)
                },
            })
            return
        }
        router.post(route('orders.store'), payload, {
            onStart: () => setProcessing(true),
            onFinish: (e) => {
                setProcessing(false)
            },
        })
    }

    useEffect(() => {
        if (!isEmpty(order)) {
            setInputedUser(order.inputed_user)
            setOrderDate(order.order_date)
            setShipDate(order.ship_date)
            setShipTime(order.ship_time)
            setOrderCustomer(order.order_customer)
            setShipCustomer(order.ship_customer)
            setPhoneShipCustomer(order.ship_customer_phone)
            setAddressShipCustomer(order.ship_customer_adress)
            setCityShipCustomer(order.ship_customer_city)
            setTypeFlower(order.type_flower)
            setTypeSize(order.type_size)
            setTypeCrest(order.type_crest)
            setBody(order.body)
            setRequestFlowerType(order.request_flower_type)
            setItemPrice(order.item_price)
            setItemQty(order.item_qty)
            setFlowerImage(order.flower_image)
            setStore(order.store)
            setCourier(order.courier)
            setBuilderName(order.builder_name)
            setBoardUse(order.board_use)
            setTimeStart(order.time_start)
            setTimeDone(order.time_done)
            setShipedTime(order.shiped_time)
            setStatus(order.status)
        }
    }, [order])

    const total = Number(item_price) * Number(item_qty)

    return (
        <AuthenticatedLayout page={'System'} action={'Order'}>
            <Head title="Order" />

            <div>
                <Card>
                    <div className="flex flex-col gap-2 justify-between">
                        <TextInput
                            readOnly={true}
                            value={order.code}
                            label="Nomor Pesanan"
                        />
                        <TextInput
                            readOnly={true}
                            label="Nama Penginput"
                            value={inputed_user?.name}
                        />
                        <div className="w-full grid md:grid-cols-3 grid-cols-1 gap-2">
                            <TextInput
                                readOnly={true}
                                value={formatDate(order_date)}
                                label={'Tanggal Pesanan'}
                            />
                            <TextInput
                                readOnly={true}
                                value={formatDate(ship_date)}
                                label={'Tanggal Pengiriman'}
                            />
                            <TextInput
                                readOnly={true}
                                label={'Jam Pengiriman'}
                                value={ship_time}
                            />
                        </div>
                        <TextInput
                            readOnly={true}
                            label="Nama Pemesan"
                            value={order_customer?.name}
                        />
                        <TextInput
                            readOnly={true}
                            label="Nama Penerima"
                            value={ship_customer?.name}
                        />
                        <div className="w-full grid grid-cols-2 gap-2">
                            <TextInput
                                readOnly={true}
                                value={phone_ship_customer}
                                label={'No.Telp Penerima'}
                            />
                            <TextInput
                                readOnly={true}
                                value={city_ship_customer}
                                label={'Kota Penerima'}
                            />
                        </div>
                        <TextareaInput
                            value={address_ship_customer}
                            label={'Alamat Penerima'}
                            rows={3}
                            readOnly={true}
                        />
                        <div className="w-full grid grid-cols-1 md:grid-cols-3 gap-2">
                            <TextInput
                                readOnly={true}
                                label="Jenis Bunga"
                                value={type_flower?.name}
                            />
                            <TextInput
                                readOnly={true}
                                label="Ukuran"
                                value={type_size?.name}
                            />
                            <TextInput
                                readOnly={true}
                                label="Jumlah Jambul"
                                value={type_crest?.name}
                            />
                        </div>
                        <TextareaInput
                            value={body}
                            label={'Isi Redaksi'}
                            rows={3}
                            readOnly={true}
                        />
                        <TextareaInput
                            value={request_flower_type}
                            label={'Permintaan Model Bunga'}
                            rows={3}
                            readOnly={true}
                        />
                        <HasPermission p="view-order-price">
                            <TextInput
                                readOnly={true}
                                value={item_price}
                                label={'Harga Satuan'}
                            />
                            <TextInput
                                readOnly={true}
                                value={item_qty}
                                label={'Jumlah'}
                            />
                            <TextInput
                                readOnly={true}
                                value={formatIDR(total)}
                                label={'Total Harga'}
                            />
                        </HasPermission>
                        {flower_image && (
                            <div className="w-48">
                                <ImageModal
                                    url={route('file.show', flower_image)}
                                />
                            </div>
                        )}
                        <TextInput
                            readOnly={true}
                            label="Toko Pembuat"
                            value={store?.name}
                        />
                        <TextInput
                            readOnly={true}
                            value={builder_name}
                            label={'Nama Perangkai'}
                        />
                        <TextInput
                            readOnly={true}
                            label="Kurir"
                            value={courier?.name}
                        />
                        <TextInput
                            readOnly={true}
                            value={board_use}
                            label={'Papan digunakan'}
                        />
                        <div className="w-full grid grid-cols-1 md:grid-cols-3 gap-2">
                            <TextInput
                                readOnly={true}
                                label={'Waktu Mulai Pembuatan'}
                                value={time_start}
                            />
                            <TextInput
                                readOnly={true}
                                label={'Waktu Selesai Pembuatan'}
                                value={time_done}
                            />
                            <TextInput
                                readOnly={true}
                                label={'Waktu Berangkat Pembuatan'}
                                value={shiped_time}
                            />
                        </div>
                        <SelectModalInput
                            label="Status"
                            value={status}
                            onChange={(item) => setStatus(item)}
                            onRemove={() => setStatus(null)}
                            error={errors.status_id}
                            params={{
                                table: 'type_statuses',
                                columns: 'id|name|address',
                                orderby: 'updated_at.desc',
                            }}
                        />
                        <div className="flex items-center">
                            <div className="flex space-x-2">
                                <Button
                                    onClick={handleSubmit}
                                    processing={processing}
                                    type="primary"
                                >
                                    Simpan
                                </Button>
                                <Link href={route('orders.index')}>
                                    <Button type="secondary">Kembali</Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </Card>
            </div>
            <CustomerFormModal
                modalState={customerModal}
                callback={handleCustomerCreated}
            />
        </AuthenticatedLayout>
    )
}
