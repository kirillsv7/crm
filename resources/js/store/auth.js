import axios from "axios";
import {reactive} from "vue";

const state = reactive({
    auth: false,
    user: {},
    permissions: []
})

const getAuthCheck = async () => {
    const response = await axios.get('/api/v1/get-auth-check')
    state.auth = response.data === 1
}

const getActiveUser = async () => {
    const response = await axios.get('/api/v1/get-active-user')
    state.user = response.data.data
}

const getActivePermissions = async () => {
    const response = await axios.get('/api/v1/get-active-permissions')
    state.permissions = response.data.data
}

export default {
    state,
    getActiveUser,
    getAuthCheck,
    getActivePermissions
}