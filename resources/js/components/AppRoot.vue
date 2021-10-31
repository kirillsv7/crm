<template>
  <SidebarMenu v-if="activeUser.name"/>
  <div class="c-wrapper">
    <AppHeader v-if="activeUser.name" :activeUser="activeUser" @unauthenticated="activeUser = {}"/>
    <router-view @authenticated="getActiveUser"/>
  </div>
</template>

<script>
import {onMounted} from "vue";
import useApp from "../composition/app";
import SidebarMenu from "./UI/SidebarMenu"
import AppHeader from "./UI/AppHeader"

export default {
  components: {
    SidebarMenu,
    AppHeader
  },

  setup() {
    const {activeUser, getActiveUser, redirectUnauthenticatedToLogin} = useApp()

    onMounted([redirectUnauthenticatedToLogin, getActiveUser])

    return {
      activeUser,
      getActiveUser
    }
  }
}
</script>