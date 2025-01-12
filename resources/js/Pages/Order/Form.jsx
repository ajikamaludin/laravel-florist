import React, { useEffect, useState } from 'react'
import { router, Head, Link, usePage } from '@inertiajs/react'
import { isEmpty, orderBy } from 'lodash'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import TextInput from '@/Components/DaisyUI/TextInput'
import Button from '@/Components/DaisyUI/Button'
import Card from '@/Components/DaisyUI/Card'
import { HiEllipsisHorizontal, HiPlus } from 'react-icons/hi2'
import SelectModalInput from '@/Components/DaisyUI/SelectModalInput'
import FormInputDate from '@/Components/DaisyUI/FormInputDate'
import FormInputTime from '@/Components/DaisyUI/FormInputTime'
import TextareaInput from '@/Components/DaisyUI/TextareaInput'
import { formatIDR, hasPermission } from '@/utils'
import FormFile from '@/Components/DaisyUI/FormFile'
import ImageModal from './ImageModal'
import { SelectOptionArray } from '@/Components/DaisyUI/SelectInput'
import CustomerFormModal from '../Customer/FormModal'
import { useModalState } from '@/hooks'

export default function Form(props) {
    const {
        props: { errors, auth },
    } = usePage()
    const { order } = props

    const [processing, setProcessing] = useState(false)
    const customerModal = useModalState()

    const [code, setCode] = useState(null)
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
            setCode(order.code)
        }
    }, [order])

    const total = Number(item_price) * Number(item_qty)

    return (
        <AuthenticatedLayout page={'System'} action={'Order'}>
            <Head title="Order" />

            <div>
                <Card>
                    <div className="flex flex-col gap-2 justify-between">
                        {isEmpty(code) === false && (
                            <TextInput
                                readOnly={true}
                                value={code}
                                label="Nomor Pesanan"
                            />
                        )}
                        <SelectModalInput
                            label="Nama Penginput"
                            value={inputed_user}
                            onChange={(item) => setInputedUser(item)}
                            onRemove={() => setInputedUser(null)}
                            error={errors.inputed_user_id}
                            params={{
                                table: 'users',
                                columns: 'id|name',
                                orderby: 'updated_at.desc',
                            }}
                        />
                        <div className="w-full grid md:grid-cols-3 grid-cols-1 gap-2">
                            <FormInputDate
                                value={order_date}
                                label={'Tanggal Pesanan'}
                                onChange={(date) => setOrderDate(date)}
                                error={errors.order_date}
                            />
                            <FormInputDate
                                value={ship_date}
                                label={'Tanggal Pengiriman'}
                                onChange={(date) => setShipDate(date)}
                                error={errors.ship_date}
                            />
                            <FormInputTime
                                label={'Jam Pengiriman'}
                                value={ship_time}
                                onChange={setShipTime}
                                error={errors.ship_time}
                            />
                        </div>
                        <div className="w-full flex flex-row gap-2 items-end">
                            <div className="flex-1">
                                <SelectModalInput
                                    label="Nama Pemesan"
                                    value={order_customer}
                                    onChange={(item) => setOrderCustomer(item)}
                                    onRemove={() => setOrderCustomer(null)}
                                    error={errors.order_customer_id}
                                    params={{
                                        table: 'customers',
                                        columns: 'id|name|city|phone',
                                        orderby: 'updated_at.desc',
                                    }}
                                />
                            </div>
                            <Button onClick={() => toggleFormCustomer('order')}>
                                <HiPlus />
                            </Button>
                        </div>
                        <div className="w-full flex flex-row gap-2 items-end">
                            <div className="flex-1">
                                <SelectModalInput
                                    label="Nama Penerima"
                                    value={ship_customer}
                                    onChange={handleShipCustomer}
                                    onRemove={() => setShipCustomer(null)}
                                    error={errors.ship_customer_id}
                                    params={{
                                        table: 'customers',
                                        headers: 'name|city|phone',
                                        columns: 'id|name|city|phone|address',
                                        orderby: 'updated_at.desc',
                                    }}
                                />
                            </div>
                            <Button onClick={() => toggleFormCustomer('ship')}>
                                <HiPlus />
                            </Button>
                        </div>
                        <div className="w-full grid grid-cols-2 gap-2">
                            <TextInput
                                value={phone_ship_customer}
                                label={'No.Telp Penerima'}
                                onChange={(e) =>
                                    setPhoneShipCustomer(e.target.value)
                                }
                                error={errors.phone_ship_customer}
                            />
                            <TextInput
                                value={city_ship_customer}
                                label={'Kota Penerima'}
                                onChange={(e) =>
                                    setCityShipCustomer(e.target.value)
                                }
                                error={errors.city_ship_customer}
                            />
                        </div>
                        <TextareaInput
                            value={address_ship_customer}
                            label={'Alamat Penerima'}
                            onChange={(e) =>
                                setAddressShipCustomer(e.target.value)
                            }
                            rows={3}
                            error={errors.address_ship_customer}
                        />
                        <div className="w-full grid grid-cols-1 md:grid-cols-3 gap-2">
                            <SelectModalInput
                                label="Jenis Bunga"
                                value={type_flower}
                                onChange={(item) => setTypeFlower(item)}
                                onRemove={() => setTypeFlower(null)}
                                error={errors.type_flower_id}
                                params={{
                                    table: 'type_flowers',
                                    columns: 'id|name',
                                    orderby: 'updated_at.desc',
                                }}
                            />
                            <SelectModalInput
                                label="Ukuran"
                                value={type_size}
                                onChange={(item) => setTypeSize(item)}
                                onRemove={() => setTypeSize(null)}
                                error={errors.type_size_id}
                                params={{
                                    table: 'type_sizes',
                                    columns: 'id|name',
                                    orderby: 'updated_at.desc',
                                }}
                            />
                            <SelectModalInput
                                label="Jumlah Jambul"
                                value={type_crest}
                                onChange={(item) => setTypeCrest(item)}
                                onRemove={() => setTypeCrest(null)}
                                error={errors.type_crest_id}
                                params={{
                                    table: 'type_crests',
                                    columns: 'id|name',
                                    orderby: 'updated_at.desc',
                                }}
                            />
                        </div>
                        <TextareaInput
                            value={body}
                            label={'Isi Redaksi'}
                            onChange={(e) => setBody(e.target.value)}
                            rows={3}
                            error={errors.body}
                        />
                        <TextareaInput
                            value={request_flower_type}
                            label={'Permintaan Model Bunga'}
                            onChange={(e) =>
                                setRequestFlowerType(e.target.value)
                            }
                            rows={3}
                            error={errors.request_flower_type}
                        />
                        <TextInput
                            value={item_price}
                            label={'Harga Satuan'}
                            onChange={(e) => setItemPrice(e.target.value)}
                            error={errors.item_price}
                        />
                        <TextInput
                            value={item_qty}
                            label={'Jumlah'}
                            onChange={(e) => setItemQty(e.target.value)}
                            error={errors.item_qty}
                        />
                        <TextInput
                            value={formatIDR(total)}
                            label={'Total Harga'}
                            readOnly={true}
                        />
                        <FormFile
                            label={'Gambar Bunga'}
                            onChange={(file_path) => setFlowerImage(file_path)}
                            error={errors.flower_image}
                            filemimes="image/jpg,image/jpeg,image/png"
                        />
                        {flower_image && (
                            <div className="w-48">
                                <ImageModal
                                    url={route('file.show', flower_image)}
                                />
                            </div>
                        )}
                        <SelectModalInput
                            label="Toko Pembuat"
                            value={store}
                            onChange={(item) => setStore(item)}
                            onRemove={() => setStore(null)}
                            error={errors.store_id}
                            params={{
                                table: 'stores',
                                columns: 'id|name',
                                orderby: 'updated_at.desc',
                            }}
                        />
                        <TextInput
                            value={builder_name}
                            label={'Nama Perangkai'}
                            onChange={(e) => setBuilderName(e.target.value)}
                            error={errors.builder_name}
                        />
                        <SelectModalInput
                            label="Kurir"
                            value={courier}
                            onChange={(item) => setCourier(item)}
                            onRemove={() => setCourier(null)}
                            error={errors.courier_id}
                            params={{
                                table: 'couriers',
                                columns: 'id|name|address',
                                orderby: 'updated_at.desc',
                            }}
                        />
                        <SelectOptionArray
                            value={board_use}
                            label={'Papan digunakan'}
                            options={['Baru', 'Stock']}
                            onChange={(e) => setBoardUse(e.target.value)}
                            error={errors.board_use}
                        />
                        <div className="w-full grid grid-cols-1 md:grid-cols-3 gap-2">
                            <FormInputTime
                                label={'Waktu Mulai Pembuatan'}
                                value={time_start}
                                onChange={(time) => setTimeStart(time)}
                                error={errors.time_start}
                            />
                            <FormInputTime
                                label={'Waktu Selesai Pembuatan'}
                                value={time_done}
                                onChange={(time) => setTimeDone(time)}
                                error={errors.time_done}
                            />
                            <FormInputTime
                                label={'Waktu Berangkat Pembuatan'}
                                value={shiped_time}
                                onChange={(time) => setShipedTime(time)}
                                error={errors.shiped_time}
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
