<template>
  <SidebarMenu v-if="authCheck"/>
  <div class="c-wrapper" v-if="authCheck">
    <AppHeader @unauthenticated="getAuthCheck()"/>
    <router-view/>
  </div>
  <LoginForm v-if="!authCheck" @authenticated="getAuthCheck()"/>
</template>

<script>
import {onBeforeMount} from "vue";
import useApp from "../composition/app";
import LoginForm from "./Auth/LoginForm";
import SidebarMenu from "./UI/SidebarMenu"
import AppHeader from "./UI/AppHeader"

export default {
  components: {
    LoginForm,
    SidebarMenu,
    AppHeader
  },

  setup() {
    const {authCheck, getAuthCheck} = useApp()

    onBeforeMount(getAuthCheck)

    return {
      authCheck,
      getAuthCheck
    }
  }
}
</script>