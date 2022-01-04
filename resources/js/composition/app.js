import {ref} from "vue";
import axios from "axios";

export default function useApp() {

    const activeUser = ref({})
    const authCheck = ref(false)

    const getActiveUser = async () => {
        const response = await axios.get('/api/v1/get-active-user')
        activeUser.value = response.data
    }

    const getAuthCheck = async () => {
        const response = await axios.get('/api/v1/get-auth-check')
        authCheck.value = response.data === 1
    }

    return {
        activeUser,
        authCheck,
        getActiveUser,
        getAuthCheck,
    }
}