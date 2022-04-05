import {ref} from "vue"
import {useRoute, useRouter} from "vue-router"
import axios from "axios"

export default function useTask() {

    const route = useRoute()
    const router = useRouter()
    const tasks = ref({})
    const pagination = ref({})
    const task = ref({
        responses: []
    })
    const tasksDeleted = ref({})
    const statusList = ref({})
    const errors = ref({})

    const getTasks = async (filter = {}) => {
        let response = await axios.get('/api/v1/task', {
            params: {
                page: route.query.page,
                project_id: filter.project_id,
                client_id: filter.client_id,
                user_id: filter.user_id,
                status_id: filter.status_id,
            }
        })
        tasks.value = response.data.data
        pagination.value = response.data.meta
    }

    const getTask = async (id) => {
        let response = await axios.get(`/api/v1/task/${id}`)
        task.value = response.data.data
    }

    const storeTask = async (task) => {
        errors.value = {}
        try {
            const response = await axios.post('/api/v1/task', task)
            await router.push({
                name: 'task.edit',
                params: {
                    id: response.data.data.id,
                    created: true
                }
            })
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    const updateTask = async (id) => {
        errors.value = {}
        try {
            await axios.put(`/api/v1/task/${id}`, task.value)
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    const destroyTask = async (id) => {
        await axios.delete(`/api/v1/task/${id}`)
    }

    const getTasksDeleted = async () => {
        let response = await axios.get('/api/v1/task/deleted', {
            params: {
                page: route.query.page
            }
        })
        tasksDeleted.value = response.data.data
        pagination.value = response.data.meta
    }

    const restoreTask = async (id) => {
        await axios.post(`/api/v1/task/${id}`)
    }

    const getStatusList = async () => {
        let response = await axios.get('/api/v1/task/statuslist')
        statusList.value = response.data.data
    }

    const addResponse = async (taskResponse) => {
        errors.value = {}
        try {
            const response = await axios.post('/api/v1/task/add-response', taskResponse)
            return response.data.data
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
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
        addResponse
    }
}