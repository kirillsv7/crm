import {ref} from "vue"
import {useRoute, useRouter} from "vue-router"
import axios from "axios"

export default function useTask() {

    const route = useRoute()
    const router = useRouter()
    const tasks = ref({})
    const pagination = ref({})
    const task = ref({})
    const tasksDeleted = ref({})
    const statusList = ref({})
    const errors = ref({})

    const getTasks = async () => {
        const response = await axios.get('/api/v1/task', {params: route.query})
        tasks.value = response.data.data
        pagination.value = response.data.meta
    }

    const getTask = async (id) => {
        const response = await axios.get(`/api/v1/task/${id}`)
        task.value = response.data.data
    }

    const storeTask = async () => {
        try {
            errors.value = {}
            const response = await axios.post('/api/v1/task', task.value)
            await router.push({
                name: 'task.edit',
                params: {
                    id: response.data.data.id,
                    created: true
                }
            })
        } catch (e) {
            await handleException(e)
        }
    }

    const updateTask = async (id) => {
        try {
            errors.value = {}
            await axios.put(`/api/v1/task/${id}`, task.value)
        } catch (e) {
            await handleException(e)
        }
    }

    const destroyTask = async (id) => {
        await axios.delete(`/api/v1/task/${id}`)
        await getTasks()
    }

    const getTasksDeleted = async () => {
        const response = await axios.get('/api/v1/task/deleted', {params: route.query})
        tasks.value = response.data.data
        pagination.value = response.data.meta
    }

    const restoreTask = async (id) => {
        await axios.post(`/api/v1/task/${id}`)
        await getTasksDeleted()
    }

    const getStatusList = async () => {
        const response = await axios.get('/api/v1/task/statuslist')
        statusList.value = response.data.data
    }

    const addResponse = async (taskResponse) => {
        try {
            errors.value = {}
            const response = await axios.post('/api/v1/task/add-response', taskResponse)
            return response.data.data
        } catch (e) {
            await handleException(e)
        }
    }

    const getRecentlyResponsed = async () => {
        const response = await axios.get('/api/v1/task/recently-responsed')
        tasks.value = response.data.data
    }

    const handleException = (e) => {
        switch (e.response.status) {
            case 422:
                errors.value = e.response.data.errors
                throw new Error('Check fields!')
                break
            case 403:
                throw new Error('Not autorized!')
                break
            default:
                console.log(e.response)
                break
        }
    }

    return {
        tasks,
        pagination,
        task,
        tasksDeleted,
        statusList,
        errors,
        getTasks,
        getTask,
        storeTask,
        updateTask,
        destroyTask,
        getTasksDeleted,
        restoreTask,
        getStatusList,
        addResponse,
        getRecentlyResponsed
    }
}