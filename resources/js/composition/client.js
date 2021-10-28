import {ref} from "vue"
import {useRoute, useRouter} from "vue-router";
import axios from "axios";

export default function useClient() {

    const route = useRoute()
    const router = useRouter()
    const clients = ref({})
    const pagination = ref({
        links: {},
        meta: {}
    })
    const client = ref({})
    const clientsDeleted = ref({})
    const errors = ref({})
    const created = ref(false)
    const updated = ref(false)
    const deleted = ref(false)

    const getClients = async () => {
        let response = await axios.get('/api/v1/client', {
            params: {
                page: route.query.page
            }
        })
        clients.value = response.data.data
        pagination.value = response.data.meta
    }

    const getClient = async (id) => {
        let response = await axios.get(`/api/v1/client/${id}`)
        client.value = response.data.data
    }

    const storeClient = async (client) => {
        errors.value = {}
        try {
            const response = await axios.post('/api/v1/client', client)
            created.value = true
            await router.push({name: 'client.edit', params: {id: response.data.data.id}})
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    const updateClient = async (id) => {
        errors.value = {}
        updated.value = false
        try {
            await axios.put(`/api/v1/client/${id}`, client.value)
            updated.value = true
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    const destroyClient = async (id) => {
        await axios.delete(`/api/v1/client/${id}`)
    }

    const getClientsDeleted = async () => {
        let response = await axios.get('/api/v1/client/deleted', {
            params: {
                page: route.query.page
            }
        })
        clientsDeleted.value = response.data.data
        pagination.value = response.data.meta
    }

    const restoreClient = async (id) => {
        await axios.post(`/api/v1/client/${id}`)
    }

    return {
        clients,
        pagination,
        client,
        clientsDeleted,
        errors,
        created,
        updated,
        deleted,
        getClients,
        getClient,
        storeClient,
        updateClient,
        destroyClient,
        getClientsDeleted,
        restoreClient
    }
}