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
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
        <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <i class="c-sidebar-nav-icon cil-user"></i>
          Users
        </a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item">
            <router-link
                class="c-sidebar-nav-link"
                :class="{'c-active': this.$route.name == 'user.index'}"
                :to="{name:'user.index'}">
              <i class="c-sidebar-nav-icon cil-list-rich"></i>
              User list
            </router-link>
          </li>
          @can('create', \App\Models\User::class)
          <li class="c-sidebar-nav-item">
            <router-link
                class="c-sidebar-nav-link"
                :class="{'c-active': this.$route.name == 'user.create'}"
                :to="{name:'user.create'}">
              <i class="c-sidebar-nav-icon cil-user-plus"></i>
              Add user
            </router-link>
          </li>
          @endcan
          <li class="c-sidebar-nav-item">
            <router-link
                class="c-sidebar-nav-link"
                :class="{'c-active': this.$route.name == 'user.deleted'}"
                :to="{name:'user.deleted'}">
              <i class="c-sidebar-nav-icon cil-user-x"></i>
              Deleted users
            </router-link>
          </li>
        </ul>
      </li>
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
        <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <i class="c-sidebar-nav-icon cil-address-book"></i>
          Clients
        </a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item">
            <router-link
                class="c-sidebar-nav-link"
                :class="{'c-active': this.$route.name == 'client.index'}"
                :to="{name:'client.index'}">
              <i class="c-sidebar-nav-icon cil-list-rich"></i>
              Client list
            </router-link>
          </li>
          @can('create', \App\Models\Client::class)
          <li class="c-sidebar-nav-item">
            <router-link
                class="c-sidebar-nav-link"
                :class="{'c-active': this.$route.name == 'client.create'}"
                :to="{name:'client.create'}">
              <i class="c-sidebar-nav-icon cil-plus"></i>
              Add client
            </router-link>
          </li>
          @endcan
          <li class="c-sidebar-nav-item">
            <router-link
                class="c-sidebar-nav-link"
                :class="{'c-active': this.$route.name == 'client.deleted'}"
                :to="{name:'client.deleted'}">
              <i class="c-sidebar-nav-icon cil-user-x"></i>
              Deleted clients
            </router-link>
          </li>
        </ul>
      </li>
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
        <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <i class="c-sidebar-nav-icon cil-briefcase"></i>
          Projects
        </a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item">
            <router-link
                class="c-sidebar-nav-link"
                :class="{'c-active': this.$route.name == 'project.index'}"
                :to="{name:'project.index'}">
              <i class="c-sidebar-nav-icon cil-list-rich"></i>
              Project list
            </router-link>
          </li>
          @can('create', \App\Models\Project::class)
          <li class="c-sidebar-nav-item">
            <router-link
                class="c-sidebar-nav-link"
                :class="{'c-active': this.$route.name == 'project.create'}"
                :to="{name:'project.create'}">
              <i class="c-sidebar-nav-icon cil-plus"></i>
              Add project
            </router-link>
          </li>
          @endcan
          <li class="c-sidebar-nav-item">
            <router-link
                class="c-sidebar-nav-link"
                :class="{'c-active': this.$route.name == 'project.deleted'}"
                :to="{name:'project.deleted'}">
              <i class="c-sidebar-nav-icon cil-minus"></i>
              Deleted projects
            </router-link>
          </li>
        </ul>
      </li>
      <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
        <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
          <i class="c-sidebar-nav-icon cil-task"></i>
          Tasks
        </a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/task">
              <i class="c-sidebar-nav-icon cil-list-rich"></i>
              Task list
            </a>
          </li>
          @can('create', \App\Models\Task::class)
          <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/task/create">
              <i class="c-sidebar-nav-icon cil-plus"></i>
              Add task
            </a>
          </li>
          @endcan
          <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/task/deleted">
              <i class="c-sidebar-nav-icon cil-minus"></i>
              Deleted tasks
            </a>
          </li>
        </ul>
      </li>

      <i class="cis-playlist-add-check"></i>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized">
    </button>
  </div>
</template>

<script>
export default {
  name: 'SidebarMenu'
}
</script>