import {useRouter} from "vue-router";
import {ref} from "vue";
import axios from "axios";

export default function useAuth() {

    const router = useRouter()
    const login = ref({})
    const user = ref({})
    const errors = ref({})

    const postLogin = async () => {
        await axios.get('/sanctum/csrf-cookie')
        try {
            await axios.post('/login', login.value)
            await router.push({name: 'dashboard'})
        } catch (e) {
            errors.value = e.response.data.errors
        }
    }

    const postLogout = async () => {
        await axios.post('/logout')
        await router.push({name: 'auth.login'})
    }

    return {
        login,
        user,
        errors,
        postLogin,
        postLogout
    }
}