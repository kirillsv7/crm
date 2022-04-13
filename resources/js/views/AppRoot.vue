<template>
  <div class="loading" v-if="loading"></div>
  <SidebarMenu v-if="state.authCheck"/>
  <div class="c-wrapper">
    <AppHeader v-if="state.authCheck"/>
    <router-view/>
  </div>
</template>

<script>
import {onMounted, provide, ref, watch} from "vue";
import {useRouter} from "vue-router";
import auth from "../store/auth";
import SidebarMenu from "../components/UI/SidebarMenu";
import AppHeader from "../components/UI/AppHeader";

export default {
  components: {
    SidebarMenu,
    AppHeader
  },

  setup() {
    const router = useRouter()
    const {state, getAuthCheck} = auth
    const loading = ref(true)

    onMounted(async () => {
      await getAuthCheck()
      if (!state.authCheck)
        await router.push({name: 'auth.login'})
      loading.value = false
    })

    watch(() => state.authCheck, async (authCheck) => {
      if (!authCheck)
        await router.push({name: 'auth.login'})
    })

    provide('auth', auth)

    return {
      loading,
      state,
    }
  }
}
</script>

<style lang="scss" scoped>
.loading {
  background: #ebedef;
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  z-index: 999;
}
</style>