<template>
  <div class="container my-auto">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">

            <form id="login-form" @submit.prevent="postLogin">

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                <div class="col-md-6">
                  <input class="form-control" name="email" type="email" autocomplete="email"
                         :class="{'is-invalid': errors.email}"
                         v-model="login.email">
                  <div class="invalid-feedback" v-if="errors.email">
                    <template v-for="error in errors.email">
                      {{ error }}
                    </template>
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <div class="col-md-6">
                  <input class="form-control" name="password" type="password" autocomplete="current-password"
                         :class="{'is-invalid': errors.password}"
                         v-model="login.password">
                  <div class="invalid-feedback" v-if="errors.password">
                    <template v-for="error in errors.password">
                      {{ error }}
                    </template>
                  </div>
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
import {ref} from "vue";

export default {
  setup(props, {emit}) {
    const login = {}
    const errors = ref({})

    const postLogin = async () => {
      await axios.get('/sanctum/csrf-cookie').then(async () => {
        await axios.post('/login', {...login}).then(function () {
          emit('authenticated')
        }).catch(function (e) {
          errors.value = e.response.data.errors
        })
      })
    }

    return {
      login,
      errors,
      postLogin
    }
  }
}
</script>