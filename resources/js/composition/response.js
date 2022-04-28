import {ref} from "vue"
import {useRoute} from "vue-router";
import axios from "axios"

export default function useResponse() {

    const route = useRoute()
    const responses = ref({})
    const pagination = ref({})

    const getResponsesByTask = async (taskId) => {
        const response = await axios.get(`/api/v1/response/get-by-task/${taskId}`, {params: route.query})
        responses.value = response.data.data
        pagination.value = response.data.meta
    }

    const getLatestResponses = () => {
        axios.get('/api/v1/response/latest')
            .then(response => {
                responses.value = response.data.data
            })
    }

    return {
        responses,
        pagination,
        getResponsesByTask,
        getLatestResponses
    }
}