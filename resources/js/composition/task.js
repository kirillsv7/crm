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
        let response = await axios.get('/api/v1/task', {
            params: route.query
        })
        tasks.value = response.data.data
        pagination.value = response.data.meta
    }

    const getTask = async (id) => {
        let response = await axios.get(`/api/v1/task/${id}`)
        task.value = response.data.data
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
            .catch(processException)
    }

    const updateTask = async (id) => {
        errors.value = {}
        await axios.put(`/api/v1/task/${id}`, task.value)
            .catch(processException)
    }

    const destroyTask = async (id) => {
        await axios.delete(`/api/v1/task/${id}`)
        await getTasks()
    }

    const getTasksDeleted = async () => {
        let response = await axios.get('/api/v1/task-deleted', {
            params: route.query
        })
        tasksDeleted.value = response.data.data
        pagination.value = response.data.meta
    }

    const restoreTask = async (id) => {
        await axios.post(`/api/v1/task/${id}`)
        await getTasksDeleted()
    }

    const getStatusList = async () => {
        let response = await axios.get('/api/v1/task/statuslist')
        statusList.value = response.data.data
    }

    const addResponse = async (taskResponse) => {
        errors.value = {}
        let addedResponse = null
        await axios.post('/api/v1/task/add-response', taskResponse)
            .then(response => {
                addedResponse = response.data.data
            })
            .catch(processException)

        return addedResponse
    }

    const processException = (e) => {
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