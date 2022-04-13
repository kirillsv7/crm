<template>
  <header class="c-header c-header-light px-3">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
            data-class="c-sidebar-show">
      <i class="cil-hamburger-menu"></i>
    </button>
    <ul class="c-header-nav ml-auto">
      <li class="c-header-nav-item px-3">
        <i class="c-icon cil-user mr-2"></i>
        {{ state.activeUser.name }}
      </li>
      <li class="c-header-nav-item px-3">
        <button class="btn btn-link" @click="postLogout">
          <i class="c-icon cil-account-logout mr-2"></i>
          Logout
        </button>
      </li>

    </ul>
  </header>
</template>

<script>
import {inject, onMounted} from "vue";
import axios from "axios";

export default {
  name: 'AppHeader',

  setup() {
    const {state, getAuthCheck, getActiveUser} = inject('auth')
    const postLogout = async () => {
      await axios.post('/logout')
          .then(getAuthCheck)
    }

    onMounted(getActiveUser)

    return {
      state,
      postLogout
    }
  }
}
</script>