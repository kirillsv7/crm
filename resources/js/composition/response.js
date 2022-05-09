import axios from "axios"
import {ref} from "vue"
import {useRoute} from "vue-router";

export default function useResponse() {

    const route = useRoute()
    const responses = ref({})
    const pagination = ref({})

    const getResponsesByTask = async (taskId) => {
        const response = await axios.get(`/api/v1/response/get-by-task/${taskId}`, {params: route.query})
        responses.value = response.data.data
        pagination.value = response.data.meta
    }

    const getLatestResponses = async () => {
        const response = await axios.get('/api/v1/response/latest')
        responses.value = response.data.data
    }

    const deleteResponse = async (id, emit) => {
        if (!window.confirm('Are you sure you want to delete?'))
            return
        await axios.delete(`/api/v1/response/${id}`)
        emit('responseDeleted')
    }
    return {
        responses,
        pagination,
        getResponsesByTask,
        deleteResponse,
        getLatestResponses
    }
}