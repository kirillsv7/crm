<template>
  <CHeader>
    <CHeaderToggler @click="visible = !visible"/>
    <CCollapse class="header-collapse" :visible="visible">
      <CHeaderNav>
        <CNavItem>
          <button class="btn" disabled>
            <CIcon :icon="cilUser"></CIcon>
            {{ state.user.name }}
          </button>
        </CNavItem>
        <CNavItem>
          <button class="btn btn-light" @click="postLogout">
            <CIcon :icon="cilAccountLogout"/>
            Logout
          </button>
        </CNavItem>
      </CHeaderNav>
    </CCollapse>
  </CHeader>
</template>

<script>
import {inject, onMounted, ref} from "vue";
import {
  CHeader,
  CHeaderToggler,
  CCollapse,
  CHeaderNav,
  CNavItem,
  CNavLink,
} from '@coreui/vue';
import {CIcon} from '@coreui/icons-vue';
import {
  cilUser,
  cilAccountLogout
} from '@coreui/icons'
import useAuth from "../../composition/auth";

export default {
  components: {
    CHeader,
    CHeaderToggler,
    CCollapse,
    CHeaderNav,
    CNavItem,
    CNavLink,
    CIcon,
  },

  setup() {
    const {state, getActiveUser} = inject('storeAuth')
    const {postLogout} = useAuth()
    const visible = ref(true)

    onMounted(getActiveUser)

    return {
      visible,
      state,
      postLogout,
      cilUser,
      cilAccountLogout
    }
  }
}
</script>