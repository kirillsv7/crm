import {reactive} from "vue";
import axios from "axios";

const state = reactive({
    auth: false,
    user: {}
})

const getAuthCheck = async () => {
    await axios.get('/api/v1/get-auth-check')
        .then(response => state.auth = response.data === 1)
}

const getActiveUser = () => {
    axios.get('/api/v1/get-active-user')
        .then(response => state.user = response.data)
}

export default {
    state,
    getActiveUser,
    getAuthCheck
}