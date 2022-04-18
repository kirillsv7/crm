import {ref} from "vue"
import {useRoute, useRouter} from "vue-router"
import axios from "axios"

export default function useUser() {

    const route = useRoute()
    const router = useRouter()
    const users = ref({})
    const userList = ref({})
    const pagination = ref({})
    const user = ref({})
    const usersDeleted = ref({})
    const errors = ref({})

    const getUsers = async () => {
        let response = await axios.get('/api/v1/user', {
            params: {
                page: route.query.page
            }
        })
        users.value = response.data.data
        pagination.value = response.data.meta
    }

    const getUser = async (id) => {
        let response = await axios.get(`/api/v1/user/${id}`)
        user.value = response.data.data
    }

    const getUserList = async () => {
        let response = await axios.get('/api/v1/user/list')
        userList.value = response.data.data
    }

    const storeUser = async (user) => {
        errors.value = {}
        try {
            const response = await axios.post('/api/v1/user', user)
            await router.push({
                name: 'user.edit',
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

    const updateUser = async (id) => {
        errors.value = {}
        try {
            await axios.put(`/api/v1/user/${id}`, user.value)
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    const destroyUser = async (id) => {
        await axios.delete(`/api/v1/user/${id}`)
    }

    const getUsersDeleted = async () => {
        let response = await axios.get('/api/v1/user/deleted', {
            params: {
                page: route.query.page
            }
        })
        usersDeleted.value = response.data.data
        pagination.value = response.data.meta
    }

    const restoreUser = async (id) => {
        await axios.post(`/api/v1/user/${id}`)
    }

    return {
        users,
        userList,
        pagination,
        user,
        usersDeleted,
        errors,
        getUsers,
        getUserList,
        getUser,
        storeUser,
        updateUser,
        destroyUser,
        getUsersDeleted,
        restoreUser
    }
}