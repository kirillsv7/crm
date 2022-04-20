<template>
  <SidebarMenu v-if="state.auth"/>
  <div class="c-wrapper">
    <AppHeader v-if="state.auth"/>
    <router-view/>
  </div>
</template>

<script>
import {onMounted, provide, watch} from "vue";
import {useRouter} from "vue-router";
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
    const {state, getAuthCheck} = storeAuth

    onMounted(() => {
      getAuthCheck().then(() => {
        if (!state.auth)
          router.push({name: 'auth.login'})
      })
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