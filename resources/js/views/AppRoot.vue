<template>
  <SidebarMenu v-if="state.auth"/>
  <div class="c-wrapper">
    <AppHeader v-if="state.auth"/>
    <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
    <router-view/>
  </div>
</template>

<script>
import {inject, provide, ref, watch} from "vue";
import {useRouter} from "vue-router";
import {AbilityBuilder, Ability} from '@casl/ability';
import {ABILITY_TOKEN} from '@casl/vue'
import storeAuth from "../store/auth";
import SidebarMenu from "../components/UI/SidebarMenu";
import AppHeader from "../components/UI/AppHeader";
import AlertElement from "../components/UI/AlertElement";

export default {
  components: {
    SidebarMenu,
    AppHeader,
    AlertElement
  },

  setup() {
    const router = useRouter()
    const ability = inject(ABILITY_TOKEN)
    const {state, getAuthCheck, getActivePermissions} = storeAuth
    const alertMessage = ref('')
    const alertClass = ref('')

    getAuthCheck().then(async () => {
      if (!state.auth)
        await router.push({name: 'auth.login'})
      else {
        await getActivePermissions()
        const {can, rules} = new AbilityBuilder(Ability)
        can(state.permissions)
        ability.update(rules)
      }
    })

    watch(() => state.auth, async (auth) => {
      if (!auth)
        await router.push({name: 'auth.login'})
    })

    provide('storeAuth', storeAuth)
    provide('alertMessage', alertMessage)
    provide('alertClass', alertClass)

    return {
      state,
      alertMessage,
      alertClass
    }
  }
}
</script>