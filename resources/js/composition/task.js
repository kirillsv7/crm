import {reactive, ref} from "vue"
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
        await axios.get('/api/v1/task', {params: route.query})
            .then(response => {
                tasks.value = response.data.data
                pagination.value = response.data.meta
            })
    }

    const getTask = async (id) => {
        await axios.get(`/api/v1/task/${id}`)
            .then(response => {
                task.value = response.data.data
            })
    }

    const storeTask = async () => {
        errors.value = {}
        await axios.post('/api/v1/task', task.value)
            .then(response => {
                router.push({
                    name: 'task.edit',
                    params: {
                        id: response.data.data.id,
                        created: true
                    }
                })
            })
            .catch(handleException)
    }

    const updateTask = async (id) => {
        errors.value = {}
        await axios.put(`/api/v1/task/${id}`, task.value)
            .catch(handleException)
    }

    const destroyTask = async (id) => {
        await axios.delete(`/api/v1/task/${id}`)
            .then(getTasks)
    }

    const getTasksDeleted = async () => {
        await axios.get('/api/v1/task/deleted', {params: route.query})
            .then(response => {
                tasksDeleted.value = response.data.data
                pagination.value = response.data.meta
            })
    }

    const restoreTask = async (id) => {
        await axios.post(`/api/v1/task/${id}`)
            .then(getTasksDeleted)
    }

    const getStatusList = async () => {
        await axios.get('/api/v1/task/statuslist')
            .then(response => {
                statusList.value = response.data.data
            })
    }

    const addResponse = async (taskResponse) => {
        errors.value = {}
        let addedResponse = null
        await axios.post('/api/v1/task/add-response', taskResponse)
            .then(response => {
                addedResponse = response.data.data
            })
            .catch(handleException)

        return addedResponse
    }

    const handleException = (e) => {
        if (e.response.status === 422)
            errors.value = e.response.data.errors
        else
            console.log(e.response)
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
        addResponse
    }
}