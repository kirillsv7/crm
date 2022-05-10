<template>
  <CSidebar visible position="fixed">
    <CSidebarBrand>
      CRM
    </CSidebarBrand>
    <CSidebarNav>
      <li class="nav-item">
        <router-link
            class="nav-link"
            :class="{'active': this.$route.name == 'dashboard'}"
            :to="{name: 'dashboard'}">
          Dashboard
        </router-link>
      </li>
      <CNavGroup>
        <template #togglerContent>
          Users
        </template>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'user.index'}"
              :to="{name:'user.index'}">
            <CIcon customClassName="nav-icon" :icon="cilListRich"/>
            List users
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'user.create'}"
              :to="{name:'user.create'}">
            <CIcon customClassName="nav-icon" :icon="cilUserPlus"/>
            Add user
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'user.deleted'}"
              :to="{name:'user.deleted'}">
            <CIcon customClassName="nav-icon" :icon="cilUserX"/>
            Deleted users
          </router-link>
        </li>
      </CNavGroup>
      <CNavGroup>
        <template #togglerContent>
          Clients
        </template>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'client.index'}"
              :to="{name:'client.index'}">
            <CIcon customClassName="nav-icon" :icon="cilListRich"/>
            List clients
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'client.create'}"
              :to="{name:'client.create'}">
            <CIcon customClassName="nav-icon" :icon="cilUserPlus"/>
            Add client
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'client.deleted'}"
              :to="{name:'client.deleted'}">
            <CIcon customClassName="nav-icon" :icon="cilUserX"/>
            Deleted clients
          </router-link>
        </li>
      </CNavGroup>
      <CNavGroup>
        <template #togglerContent>
          Projects
        </template>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'project.index'}"
              :to="{name:'project.index'}">
            <CIcon customClassName="nav-icon" :icon="cilListRich"/>
            List projects
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'project.create'}"
              :to="{name:'project.create'}">
            <CIcon customClassName="nav-icon" :icon="cilPlus"></CIcon>
            Add project
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'project.deleted'}"
              :to="{name:'project.deleted'}">
            <CIcon customClassName="nav-icon" :icon="cilMinus"></CIcon>
            Deleted projects
          </router-link>
        </li>
      </CNavGroup>
      <CNavGroup>
        <template #togglerContent>
          Tasks
        </template>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'task.index'}"
              :to="{name:'task.index'}">
            <CIcon customClassName="nav-icon" :icon="cilListRich"/>
            List tasks
          </router-link>
        </li>
        <li class="nav-item" v-if="can('task-create')">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'task.create'}"
              :to="{name:'task.create'}">
            <CIcon customClassName="nav-icon" :icon="cilPlus"></CIcon>
            Add task
          </router-link>
        </li>
        <li class="nav-item">
          <router-link
              class="nav-link"
              :class="{'active': this.$route.name == 'task.deleted'}"
              :to="{name:'task.deleted'}">
            <CIcon customClassName="nav-icon" :icon="cilMinus"></CIcon>
            Deleted tasks
          </router-link>
        </li>
      </CNavGroup>
    </CSidebarNav>
    <CSidebarToggler/>
  </CSidebar>
</template>

<script>
import {useAbility} from '@casl/vue';
import {
  CSidebar,
  CSidebarBrand,
  CSidebarNav,
  CNavGroup,
  CSidebarToggler
} from '@coreui/vue'
import {CIcon} from '@coreui/icons-vue';
import {
  cilListRich,
  cilUserPlus,
  cilUserX,
  cilPlus,
  cilMinus,
} from '@coreui/icons';

export default {
  components: {
    CSidebar,
    CSidebarBrand,
    CSidebarNav,
    CNavGroup,
    CSidebarToggler,
    CIcon
  },

  setup() {
    const {can} = useAbility();

    return {
      can,
      cilListRich,
      cilUserPlus,
      cilUserX,
      cilPlus,
      cilMinus,
    }
  }
}
</script>