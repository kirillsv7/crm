<template>
  <SidebarMenu v-if="authCheck"/>
  <div class="c-wrapper">
    <AppHeader v-if="authCheck" @unauthenticated="getAuthCheck"/>
    <router-view @authenticated="getAuthCheck"/>
  </div>
</template>

<script>
import {onBeforeMount} from "vue";
import useApp from "../composition/app";
import SidebarMenu from "../components/UI/SidebarMenu";
import AppHeader from "../components/UI/AppHeader";

export default {
  components: {
    SidebarMenu,
    AppHeader
  },

  setup() {
    const {authCheck, getAuthCheck, redirectUnauthenticatedToLogin} = useApp()

    onBeforeMount(redirectUnauthenticatedToLogin)

    return {
      authCheck,
      getAuthCheck
    }
  }
}
</script>