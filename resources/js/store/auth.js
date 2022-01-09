import {reactive} from "vue";
import axios from "axios";

const state = reactive({
    authCheck: false,
    activeUser: {}
})

const getAuthCheck = async () => {
    const response = await axios.get('/api/v1/get-auth-check')
    state.authCheck = response.data === 1
}

const getActiveUser = async () => {
    const response = await axios.get('/api/v1/get-active-user')
    state.activeUser = response.data
}

export default {
    state,
    getActiveUser,
    getAuthCheck
}