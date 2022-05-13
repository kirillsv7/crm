<template>
  <div class="container my-auto">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">

            <form id="login-form" @submit.prevent="postLogin">

              <div class="form-floating mb-3">
                <input
                    class="form-control"
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    placeholder="email@example.org"
                    :class="{'is-invalid': errors.email}"
                    v-model="login.email"
                >
                <label for="email">
                  {{ loginLabel }}
                </label>
              </div>

              <div class="form-floating mb-3">
                <input
                    class="form-control"
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="Password"
                    :class="{'is-invalid': errors.password}"
                    v-model="login.password"
                >
                <label for="email">
                  {{ passwordLabel }}
                </label>
              </div>

              <div class="form-check mb-3">
                <input
                    class="form-check-input"
                    id="remember"
                    type="checkbox"
                    name="remember"
                    v-model="login.remember"
                >
                <label class="form-check-label" for="remember">
                  Remember Me
                </label>
              </div>

              <button type="submit" class="btn btn-primary mb-2 w-100">Login</button>

              <a class="text-muted" href="#"><small>Forgot Your Password?</small></a>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {computed, inject, onBeforeUnmount, onMounted} from "vue";
import {useRouter} from "vue-router";
import {AbilityBuilder, Ability} from '@casl/ability';
import {ABILITY_TOKEN} from '@casl/vue'
import useAuth from "../../composition/auth";

export default {
  setup() {
    const router = useRouter()
    const ability = inject(ABILITY_TOKEN)
    const {state, getAuthCheck, getActivePermissions} = inject('storeAuth')
    const {login, errors, postLogin} = useAuth()

    const loginLabel = computed(() => {
      return !errors.value.email ? 'E-Mail' : errors.value.email.join(', ')
    })

    const passwordLabel = computed(() => {
      return !errors.value.password ? 'Password' : errors.value.password.join(', ')
    })

    onMounted(async () => {
      await getAuthCheck()
      if (state.auth)
        await router.push({name: 'dashboard'})
    })

    onBeforeUnmount(async () => {
      await getAuthCheck()
      await getActivePermissions()
      const {can, rules} = new AbilityBuilder(Ability)
      can(state.permissions)
      ability.update(rules)
    })

    return {
      login,
      loginLabel,
      passwordLabel,
      errors,
      postLogin
    }
  }
}
</script>