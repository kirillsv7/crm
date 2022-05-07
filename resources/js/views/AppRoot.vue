<template>
  <SidebarMenu v-if="state.auth"/>
  <div class="c-wrapper">
    <AppHeader v-if="state.auth"/>
    <router-view/>
  </div>
</template>

<script>
import {inject, provide, watch} from "vue";
import {useRouter} from "vue-router";
import {AbilityBuilder, Ability} from '@casl/ability';
import {ABILITY_TOKEN} from '@casl/vue'
import storeAuth from "../store/auth";
import SidebarMenu from "../components/UI/SidebarMenu";
import AppHeader from "../components/UI/AppHeader";

export default {
  components: {
    SidebarMenu,
    AppHeader
  },

  setup() {
    const router = useRouter()
    const ability = inject(ABILITY_TOKEN)
    const {state, getAuthCheck, getActivePermissions} = storeAuth

    getAuthCheck().then(async () => {
      if (!state.auth)
        await router.push({name: 'auth.login'})
      else {
        await getActivePermissions()
        const { can, rules } = new AbilityBuilder(Ability)
        can(state.permissions)
        ability.update(rules)
      }
    })

    watch(() => state.auth, async (auth) => {
      if (!auth)
        await router.push({name: 'auth.login'})
    })

    provide('storeAuth', storeAuth)

    return {
      state
    }
  }
}
</script>