import {useRouter} from "vue-router";
import {ref} from "vue";
import axios from "axios";

export default function useAuth() {

    const router = useRouter()
    const login = ref({})
    const user = ref({})
    const errors = ref({})

    const postLogin = () => {
        axios.get('/sanctum/csrf-cookie')
            .then(() => {
                axios.post('/login', login.value)
                    .then(() => {
                        router.push({name: 'dashboard'})
                    })
                    .catch((e) => {
                        errors.value = e.response.data.errors
                    })
            })
    }

    const postLogout = () => {
        axios.post('/logout')
            .then(() => {
                router.push({name: 'auth.login'})
            })
    }

    return {
        login,
        user,
        errors,
        postLogin,
        postLogout
    }
}