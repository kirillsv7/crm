<template>
  <div class="loading" v-if="loading"></div>
  <Login v-if="!authCheck" @authenticated="getAuthCheck"/>
  <template v-else>
    <SidebarMenu/>
    <div class="c-wrapper">
      <AppHeader @unauthenticated="getAuthCheck"/>
      <router-view/>
    </div>
  </template>
</template>

<script>
import {onMounted, ref} from "vue";
import useApp from "../composition/app";
import Login from "./Auth/Login";
import SidebarMenu from "../components/UI/SidebarMenu";
import AppHeader from "../components/UI/AppHeader";

export default {
  components: {
    Login,
    SidebarMenu,
    AppHeader
  },

  setup() {
    const {authCheck, getAuthCheck} = useApp()
    const loading = ref(true)

    onMounted(async () => {
      await getAuthCheck().then(() => {
        loading.value = false
      })
    })

    return {
      loading,
      authCheck,
      getAuthCheck
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