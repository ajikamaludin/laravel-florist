import ModalImage from 'react-modal-image'

export default function ImageModal({ url }) {
    return <ModalImage small={url} large={url} hideZoom={false} />
}
