<template>
  <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
      CRM
    </div>
    <ul class="c-sidebar-nav ps">
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'dashboard'}"
            :to="{name: 'dashboard'}"
        >
          <i class="c-sidebar-nav-icon cil-spreadsheet"></i>
          Dashboard
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'user.index'}"
            :to="{name:'user.index'}">
          <i class="c-sidebar-nav-icon cil-list-rich"></i>
          Users
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'user.create'}"
            :to="{name:'user.create'}">
          <i class="c-sidebar-nav-icon cil-user-plus"></i>
          Add user
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'user.deleted'}"
            :to="{name:'user.deleted'}">
          <i class="c-sidebar-nav-icon cil-user-x"></i>
          Deleted users
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'client.index'}"
            :to="{name:'client.index'}">
          <i class="c-sidebar-nav-icon cil-list-rich"></i>
          Clients
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'client.create'}"
            :to="{name:'client.create'}">
          <i class="c-sidebar-nav-icon cil-plus"></i>
          Add client
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'client.deleted'}"
            :to="{name:'client.deleted'}">
          <i class="c-sidebar-nav-icon cil-user-x"></i>
          Deleted clients
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'project.index'}"
            :to="{name:'project.index'}">
          <i class="c-sidebar-nav-icon cil-list-rich"></i>
          Projects
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'project.create'}"
            :to="{name:'project.create'}">
          <i class="c-sidebar-nav-icon cil-plus"></i>
          Add project
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'project.deleted'}"
            :to="{name:'project.deleted'}">
          <i class="c-sidebar-nav-icon cil-minus"></i>
          Deleted projects
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'task.index'}"
            :to="{name:'task.index'}">
          <i class="c-sidebar-nav-icon cil-list-rich"></i>
          Tasks
        </router-link>
      </li>
      <li class="c-sidebar-nav-item" v-if="can('task-create')">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'task.create'}"
            :to="{name:'task.create'}">
          <i class="c-sidebar-nav-icon cil-plus"></i>
          Add task
        </router-link>
      </li>
      <li class="c-sidebar-nav-item">
        <router-link
            class="c-sidebar-nav-link"
            :class="{'c-active': this.$route.name == 'task.deleted'}"
            :to="{name:'task.deleted'}">
          <i class="c-sidebar-nav-icon cil-minus"></i>
          Deleted tasks
        </router-link>
      </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized">
    </button>
  </div>
</template>

<script>
import {useAbility} from '@casl/vue';

export default {
  setup() {
    const {can} = useAbility();

    return {
      can
    }
  }
}
</script>