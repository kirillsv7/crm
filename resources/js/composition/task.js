import {inject, ref} from "vue"
import {useRoute, useRouter} from "vue-router"
import axios from "axios"

export default function useTask() {

    const route = useRoute()
    const router = useRouter()
    const alertMessage = inject('alertMessage')
    const alertClass = inject('alertClass')
    const tasks = ref({})
    const pagination = ref({})
    const task = ref({})
    const saved = ref(null)
    const taskResponse = ref({})
    const statusList = ref({})
    const errors = ref({})

    const getTasks = async () => {
        const response = await axios.get('/api/v1/task', {params: route.query})
        tasks.value = response.data.data
        pagination.value = response.data.meta
    }

    const getTasksByProject = async (projectId) => {
        const response = await axios.get(`/api/v1/task/get-by-project/${projectId}`, {params: route.query})
        tasks.value = response.data.data
        pagination.value = response.data.meta
    }

    const getTask = async (id) => {
        const response = await axios.get(`/api/v1/task/${id}`)
        task.value = response.data.data
    }

    const storeTask = async () => {
        const formData = convertToFormData()
        try {
            errors.value = {}
            const response = await axios.post('/api/v1/task', formData, {
                headers: {'content-type': 'multipart/form-data'}
            })
            await router.push({
                name: 'task.edit',
                params: {
                    id: response.data.data.id,
                    created: true
                }
            })
            alertMessage.value = 'Task created!'
            alertClass.value = 'success'
        } catch (e) {
            await handleException(e)
        }
    }

    const updateTask = async (id) => {
        alertMessage.value = 'Updating task...'
        alertClass.value = 'info'
        const formData = convertToFormData()
        try {
            errors.value = {}
            await axios.post(`/api/v1/task/${id}`, formData, {
                headers: {'content-type': 'multipart/form-data'},
                params: {_method: 'PUT'}
            })
            saved.value = Date.now()
            alertMessage.value = 'Task updated!'
            alertClass.value = 'success'
        } catch (e) {
            await handleException(e)
        }
    }

    const deleteTask = async (id) => {
        if (!window.confirm('Are you sure you want to delete?'))
            return
        alertMessage.value = 'Deleting task...'
        alertClass.value = 'info'
        try {
            await axios.delete(`/api/v1/task/${id}`)
            await getTasks()
            alertMessage.value = 'Task deleted!'
            alertClass.value = 'success'
        } catch (e) {
            await handleException(e)
        }
    }

    const getTasksDeleted = async () => {
        const response = await axios.get('/api/v1/task/deleted', {params: route.query})
        tasks.value = response.data.data
        pagination.value = response.data.meta
    }

    const restoreTask = async (id) => {
        if (!window.confirm('Are you sure you want to restore?'))
            return
        alertMessage.value = 'Restoring task...'
        alertClass.value = 'info'
        try {
            await axios.post(`/api/v1/task/${id}`)
            await getTasksDeleted()
            alertMessage.value = 'Task restored!'
            alertClass.value = 'success'
        } catch (e) {
            await handleException(e)
        }
    }

    const getStatusList = async () => {
        const response = await axios.get('/api/v1/task/statuslist')
        statusList.value = response.data.data
    }

    const addResponse = async (emit) => {
        const formData = convertToFormData(taskResponse)
        try {
            errors.value = {}
            const response = await axios.post('/api/v1/task/add-response', formData, {
                headers: {'content-type': 'multipart/form-data'}
            })
            taskResponse.value.content = ''
            saved.value = Date.now()
            emit('responseAdded', response.data.data.id)
        } catch (e) {
            await handleException(e.message)
        }
    }

    const getRecentlyResponsed = async () => {
        const response = await axios.get('/api/v1/task/recently-responsed')
        tasks.value = response.data.data
    }

    const convertToFormData = (dataObj = task) => {
        const formData = new FormData();
        for (let key in dataObj.value) {
            if (typeof dataObj.value[key] !== 'object')
                formData.append(key, dataObj.value[key]);
            else {
                for (let key2 in dataObj.value[key]) {
                    formData.append(key + '[]', dataObj.value[key][key2])
                }
            }
        }

        return formData
    }

    const handleException = (e) => {
        switch (e.response.status) {
            case 422:
                errors.value = e.response.data.errors
                break
            case 403:
                break
            default:
                console.log(e.response)
                break
        }
        alertMessage.value = e.response.data.message
        alertClass.value = 'danger'
    }

    return {
        tasks,
        pagination,
        task,
        saved,
        taskResponse,
        statusList,
        errors,
        getTasks,
        getTasksByProject,
        getTask,
        storeTask,
        updateTask,
        deleteTask,
        getTasksDeleted,
        restoreTask,
        getStatusList,
        addResponse,
        getRecentlyResponsed
    }
}