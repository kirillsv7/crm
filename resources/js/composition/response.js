import {ref} from "vue"
import axios from "axios"

export default function useResponse() {

    const responses = ref({})

    const getLatestResponses = () => {
        axios.get('/api/v1/response/latest')
            .then(response => {
                responses.value = response.data.data
            })
    }

    return {
        responses,
        getLatestResponses
    }
}