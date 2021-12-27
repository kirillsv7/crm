import {ref} from "vue"
import {useRoute, useRouter} from "vue-router";
import axios from "axios"

export default function useProject() {

    const route = useRoute()
    const router = useRouter()
    const projects = ref({})
    const pagination = ref({})
    const project = ref({})
    const projectsDeleted = ref({})
    const statuses = ref({})
    const errors = ref({})

    const getProjects = async () => {
        let response = await axios.get('/api/v1/project', {
            params: {
                page: route.query.page
            }
        })
        projects.value = response.data.data
        pagination.value = response.data.meta
    }

    const getProject = async (id) => {
        let response = await axios.get(`/api/v1/project/${id}`)
        project.value = response.data.data
    }

    const storeProject = async (project) => {
        errors.value = {}
        try {
            const response = await axios.post('/api/v1/project', project)
            await router.push({
                name: 'project.edit',
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

    const updateProject = async (id) => {
        errors.value = {}
        try {
            await axios.put(`/api/v1/project/${id}`, project.value)
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    const destroyProject = async (id) => {
        await axios.delete(`/api/v1/project/${id}`)
    }

    const getProjectsDeleted = async () => {
        let response = await axios.get('/api/v1/project/deleted', {
            params: {
                page: route.query.page
            }
        })
        projectsDeleted.value = response.data.data
        pagination.value = response.data.meta
    }

    const restoreProject = async (id) => {
        await axios.post(`/api/v1/project/${id}`)
    }

    const getStatuses = async () => {
        let response = await axios.get('/api/v1/project/statuses')
        statuses.value = response.data.data
    }

    return {
        projects,
        pagination,
        project,
        projectsDeleted,
        statuses,
        errors,
        getProjects,
        getProject,
        storeProject,
        updateProject,
        destroyProject,
        getProjectsDeleted,
        restoreProject,
        getStatuses
    }
}