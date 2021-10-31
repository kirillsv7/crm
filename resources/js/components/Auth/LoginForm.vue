<template>
  <div class="container my-auto">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>

          <div class="card-body">

            <div class="alert alert-danger" role="alert" v-if="Object.keys(errors).length">
              <template v-for="(error, field) in errors" :key="field">
                {{ error[0] }}<br>
              </template>
            </div>

            <form id="login-form" @submit.prevent="postLogin">

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                <div class="col-md-6">
                  <input class="form-control" name="email" type="email" autocomplete="email" autofocus
                         v-model="login.email">
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <div class="col-md-6">
                  <input class="form-control" name="password" type="password" autocomplete="current-password"
                         v-model="login.password">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" v-model="login.remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">Login</button>

                  <a class="btn btn-link" href="#">Forgot Your Password?</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onBeforeMount, ref} from "vue";
import {useRouter} from "vue-router";
import useApp from "../../composition/app";

export default {
  name: 'LoginForm',

  setup(props, {emit}) {
    const router = useRouter()
    const {redirectAuthenticatedToDashboard} = useApp()
    const login = {}
    const errors = ref({})

    const postLogin = async () => {
      await axios.get('/sanctum/csrf-cookie').then(async () => {
        await axios.post('login', {...login}).then(function () {
          emit('authenticated')
          router.push({name: 'dashboard'})
        }).catch(function (e) {
          errors.value = e.response.data.errors
        })
      })
    }

    onBeforeMount(redirectAuthenticatedToDashboard)

    return {
      login,
      postLogin,
      errors
    }
  }
}
</script>