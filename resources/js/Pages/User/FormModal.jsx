import React, { useEffect } from 'react'
import { useForm } from '@inertiajs/react'
import { isEmpty } from 'lodash'

import Modal from '@/Components/DaisyUI/Modal'
import Button from '@/Components/DaisyUI/Button'
import TextInput from '@/Components/DaisyUI/TextInput'
import SelectModalInput from '@/Components/DaisyUI/SelectModalInput'

export default function FormModal(props) {
    const { modalState } = props
    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            name: '',
            email: '',
            password: '',
            role_id: null,
            role: '',
            store_id: null,
            store: '',
        })

    const handleOnChange = (event) => {
        setData(
            event.target.name,
            event.target.type === 'checkbox'
                ? event.target.checked
                    ? 1
                    : 0
                : event.target.value
        )
    }

    const handleReset = () => {
        modalState.setData(null)
        reset()
        clearErrors()
    }

    const handleClose = () => {
        handleReset()
        modalState.toggle()
    }

    const handleSubmit = () => {
        const user = modalState.data
        if (user !== null) {
            put(route('user.update', user), {
                onSuccess: () => handleClose(),
            })
            return
        }
        post(route('user.store'), {
            onSuccess: () => handleClose(),
        })
    }

    useEffect(() => {
        const user = modalState.data
        if (isEmpty(user) === false) {
            setData(user)
            return
        }
    }, [modalState])

    return (
        <Modal isOpen={modalState.isOpen} onClose={handleClose} title={'User'}>
            <div className="form-control space-y-2.5">
                <TextInput
                    name="name"
                    value={data.name}
                    onChange={handleOnChange}
                    label="Name"
                    error={errors.name}
                />

                <TextInput
                    name="email"
                    value={data.email}
                    onChange={handleOnChange}
                    label="Email"
                    error={errors.email}
                />
                <TextInput
                    type="password"
                    name="password"
                    value={data.password}
                    onChange={handleOnChange}
                    label="Password"
                    error={errors.password}
                />
                {data.role !== null && (
                    <>
                        <SelectModalInput
                            label="Role"
                            value={data.role}
                            onChange={(item) =>
                                setData({
                                    ...data,
                                    role: item,
                                    role_id: item ? item.id : null,
                                })
                            }
                            onRemove={() =>
                                setData({ ...data, role: '', role_id: null })
                            }
                            error={errors.role_id}
                            params={{
                                table: 'roles',
                                columns: 'id|name',
                                orderby: 'updated_at.desc',
                            }}
                        />
                        <SelectModalInput
                            label="Toko"
                            value={data.store}
                            onChange={(item) =>
                                setData({
                                    ...data,
                                    store: item,
                                    store_id: item ? item.id : null,
                                })
                            }
                            onRemove={() =>
                                setData({ ...data, store: '', store_id: null })
                            }
                            error={errors.store_id}
                            params={{
                                table: 'stores',
                                columns: 'id|name|city',
                                orderby: 'updated_at.desc',
                            }}
                        />
                    </>
                )}
            </div>
            <div className="flex items-center space-x-2 mt-4">
                <Button
                    onClick={handleSubmit}
                    processing={processing}
                    type="primary"
                >
                    Simpan
                </Button>
                <Button onClick={handleClose} type="secondary">
                    Batal
                </Button>
            </div>
        </Modal>
    )
}
