import axios from "axios";
import {reactive} from "vue";

const state = reactive({
    auth: false,
    user: {},
    permissions: []
})

const getAuthCheck = async () => {
    await axios.get('/api/v1/get-auth-check')
        .then(response => state.auth = response.data === 1)
}

const getActiveUser = () => {
    axios.get('/api/v1/get-active-user')
        .then(response => state.user = response.data)
}

const getActivePermissions = async () => {
    await axios.get('/api/v1/get-active-permissions')
        .then(response => state.permissions = response.data)
}

export default {
    state,
    getActiveUser,
    getAuthCheck,
    getActivePermissions
}