import React, { useEffect } from 'react'
import { useForm } from '@inertiajs/react'
import { isEmpty } from 'lodash'

import Modal from '@/Components/DaisyUI/Modal'
import Button from '@/Components/DaisyUI/Button'
import TextInput from '@/Components/DaisyUI/TextInput'
import TextareaInput from '@/Components/DaisyUI/TextareaInput'

export default function FormModal(props) {
    const { modalState } = props
    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            name: '',
            city: '',
            phone: '',
            address: '',
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
        const store = modalState.data
        if (store !== null) {
            put(route('stores.update', store), {
                onSuccess: () => handleClose(),
            })
            return
        }
        post(route('stores.store'), {
            onSuccess: () => handleClose(),
        })
    }

    useEffect(() => {
        const store = modalState.data
        if (isEmpty(store) === false) {
            setData(store)
            return
        }
    }, [modalState])

    return (
        <Modal isOpen={modalState.isOpen} onClose={handleClose} title={'Store'}>
            <div className="form-control space-y-2.5">
                <TextInput
                    name="name"
                    value={data.name}
                    onChange={handleOnChange}
                    label="Nama"
                    error={errors.name}
                />
                <TextInput
                    name="city"
                    value={data.city}
                    onChange={handleOnChange}
                    label="Kota"
                    error={errors.city}
                />
                <TextInput
                    name="phone"
                    value={data.phone}
                    onChange={handleOnChange}
                    label="Phone"
                    error={errors.phone}
                />
                <TextareaInput
                    name="address"
                    value={data.address}
                    onChange={handleOnChange}
                    label="Alamat"
                    error={errors.address}
                />

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
            </div>
        </Modal>
    )
}
