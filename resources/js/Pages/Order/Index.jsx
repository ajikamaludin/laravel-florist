import React, { useEffect, useState } from 'react'
import { router } from '@inertiajs/react'
import { usePrevious } from 'react-use'
import { Head, Link } from '@inertiajs/react'
import { HiEye, HiPencil, HiTrash } from 'react-icons/hi2'
import { useModalState } from '@/hooks'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import Pagination from '@/Components/DaisyUI/Pagination'
import ModalConfirm from '@/Components/DaisyUI/ModalConfirm'
import SearchInput from '@/Components/DaisyUI/SearchInput'
import HasPermission from '@/Components/Common/HasPermission'
import Dropdown from '@/Components/DaisyUI/Dropdown'
import Button from '@/Components/DaisyUI/Button'
import Card from '@/Components/DaisyUI/Card'
import { formatDate } from '@/utils'

export default function Index(props) {
    const {
        data: { links, data },
    } = props

    const [search, setSearch] = useState('')
    const preValue = usePrevious(search)

    const confirmModal = useModalState()

    const handleDeleteClick = (order) => {
        confirmModal.setData(order)
        confirmModal.toggle()
    }

    const onDelete = () => {
        if (confirmModal.data !== null) {
            router.delete(route('orders.destroy', confirmModal.data.id))
        }
    }

    const params = { q: search }
    useEffect(() => {
        if (preValue) {
            router.get(
                route(route().current()),
                { q: search },
                {
                    replace: true,
                    preserveState: true,
                }
            )
        }
    }, [search])

    return (
        <AuthenticatedLayout page={'System'} action={'Order'}>
            <Head title="Order" />

            <div>
                <Card>
                    <div className="flex justify-between">
                        <HasPermission p="create-order">
                            <Link href={route('orders.create')}>
                                <Button size="sm" type="primary">
                                    Tambah
                                </Button>
                            </Link>
                        </HasPermission>

                        <div className="flex items-center">
                            <SearchInput
                                onChange={(e) => setSearch(e.target.value)}
                                value={search}
                            />
                        </div>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Toko</th>
                                    <th>Tanggal Pesanan</th>
                                    <th>Tanggal Pengiriman</th>
                                    <th>Nama Penerima</th>
                                    <th>Kota Pengiriman</th>
                                    <th>Status</th>
                                    <th />
                                </tr>
                            </thead>
                            <tbody>
                                {data.map((order, index) => (
                                    <tr key={order.id}>
                                        <td>{order.code}</td>
                                        <td>{order.store.name}</td>
                                        <td>{formatDate(order.order_date)}</td>
                                        <td>{formatDate(order.ship_date)}</td>
                                        <td>{order.ship_customer.name}</td>
                                        <td>{order.ship_customer.city}</td>
                                        <td>{order.status.name}</td>
                                        <td className="text-right">
                                            <Dropdown>
                                                <Dropdown.Item
                                                    onClick={() =>
                                                        router.visit(
                                                            route(
                                                                'orders.show',
                                                                order
                                                            )
                                                        )
                                                    }
                                                >
                                                    <div className="flex space-x-1 items-center">
                                                        <HiEye />
                                                        <div>Detail</div>
                                                    </div>
                                                </Dropdown.Item>
                                                <HasPermission p="update-order">
                                                    <Dropdown.Item
                                                        onClick={() =>
                                                            router.visit(
                                                                route(
                                                                    'orders.edit',
                                                                    order
                                                                )
                                                            )
                                                        }
                                                    >
                                                        <div className="flex space-x-1 items-center">
                                                            <HiPencil />
                                                            <div>Ubah</div>
                                                        </div>
                                                    </Dropdown.Item>
                                                </HasPermission>
                                                <HasPermission p="delete-order">
                                                    <Dropdown.Item
                                                        onClick={() =>
                                                            handleDeleteClick(
                                                                order
                                                            )
                                                        }
                                                    >
                                                        <div className="flex space-x-1 items-center">
                                                            <HiTrash />
                                                            <div>Hapus</div>
                                                        </div>
                                                    </Dropdown.Item>
                                                </HasPermission>
                                            </Dropdown>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div className="w-full overflow-x-auto flex lg:justify-center">
                        <Pagination links={links} params={params} />
                    </div>
                </Card>
            </div>
            <ModalConfirm modalState={confirmModal} onConfirm={onDelete} />
        </AuthenticatedLayout>
    )
}
