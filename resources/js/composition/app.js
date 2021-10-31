import {ref} from "vue";
import {useRouter} from "vue-router";
import axios from "axios";

export default function useApp() {

    const router = useRouter()
    const activeUser = ref({})
    const authCheck = ref(false)

    const getActiveUser = async () => {
        const response = await axios.get('/api/v1/get-active-user')
        activeUser.value = response.data
    }

    const getAuthCheck = async () => {
        const response = await axios.get('/api/v1/get-auth-check')
        if (response.data == 1)
            authCheck.value = true
        else
            authCheck.value = false
    }

    const redirectUnauthenticatedToLogin = async () => {
        await getAuthCheck()
        if (!authCheck.value) {
            await router.push({name: 'auth.login'})
        }
    }

    const redirectAuthenticatedToDashboard = async () => {
        await getAuthCheck()
        if (authCheck.value) {
            await router.push({name: 'dashboard'})
        }
    }

    return {
        activeUser,
        authCheck,
        getActiveUser,
        getAuthCheck,
        redirectUnauthenticatedToLogin,
        redirectAuthenticatedToDashboard
    }
}