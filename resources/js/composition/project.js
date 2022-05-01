import {ref} from "vue"
import {useRoute, useRouter} from "vue-router"
import axios from "axios"

export default function useProject() {

    const route = useRoute()
    const router = useRouter()
    const projects = ref({})
    const pagination = ref({})
    const projectList = ref({})
    const project = ref({})
    const statusList = ref({})
    const errors = ref({})

    const getProjects = async () => {
        let response = await axios.get('/api/v1/project', {params: route.query})
        projects.value = response.data.data
        pagination.value = response.data.meta
    }

    const getProjectList = async () => {
        let response = await axios.get('/api/v1/project/list')
        projectList.value = response.data.data
    }

    const getProject = async (id) => {
        let response = await axios.get(`/api/v1/project/${id}`)
        project.value = response.data.data
    }

    const storeProject = async () => {
        const formData = convertProjectToFormData()
        try {
            errors.value = {}
            const response = await axios.post('/api/v1/project', formData, {
                headers: {'content-type': 'multipart/form-data'}
            })
            await router.push({
                name: 'project.edit',
                params: {
                    id: response.data.data.id,
                    created: true
                }
            })
        } catch (e) {
            await handleException(e)
        }
    }

    const updateProject = async (id) => {
        const formData = convertProjectToFormData()
        try {
            errors.value = {}
            await axios.post(`/api/v1/project/${id}`, formData, {
                headers: {'content-type': 'multipart/form-data'},
                params: {_method: 'PUT'}
            })
        } catch (e) {
            await handleException(e)
        }
    }

    const destroyProject = async (id) => {
        await axios.delete(`/api/v1/project/${id}`)
        await getProjects()
    }

    const getProjectsDeleted = async () => {
        const response = await axios.get('/api/v1/project/deleted', {params: route.query})
        projects.value = response.data.data
        pagination.value = response.data.meta
    }

    const restoreProject = async (id) => {
        await axios.post(`/api/v1/project/${id}`)
        await getProjectsDeleted()
    }

    const getStatusList = async () => {
        const response = await axios.get('/api/v1/project/statuslist')
        statusList.value = response.data.data
    }

    const getRecentlyAddedTask = async () => {
        const response = await axios.get('api/v1/project/recently-added-task')
        projects.value = response.data.data

    }

    const convertProjectToFormData = () => {
        const formData = new FormData();
        for (let key in project.value) {
            if (typeof project.value[key] !== 'object')
                formData.append(key, project.value[key]);
            else {
                for (let key2 in project.value[key]) {
                    formData.append(key + '[]', project.value[key][key2])
                }
            }
        }

        return formData
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
        projects,
        projectList,
        pagination,
        project,
        statusList,
        errors,
        getProjects,
        getProjectList,
        getProject,
        storeProject,
        updateProject,
        destroyProject,
        getProjectsDeleted,
        restoreProject,
        getStatusList,
        getRecentlyAddedTask
    }
}