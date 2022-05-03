import axios from "axios";

export default function useMedia() {

    const destroyMedia = async (id) => {
        await axios.delete(`/api/v1/media/${id}`)
    }

    return {
        destroyMedia
    }
}