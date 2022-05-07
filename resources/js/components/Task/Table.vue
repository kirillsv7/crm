<template>
  <div class="table-responsive">
    <table class="table table-borderless table-hover">
      <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Project</th>
        <th>Client</th>
        <th>User</th>
        <th>Responses</th>
        <th class="text-nowrap">Last response</th>
        <th>Status</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Actions</th>
      </tr>
      <tr v-if="availableFilters.length">
        <td></td>
        <td></td>
        <td>
          <select class="form-control" v-if="availableFilters.includes('project')" v-model="filter.project_id">
            <option :value="null">Filter by project</option>
            <template v-for="project in projectList" :key="project.id">
              <option :value="project.id">
                {{ project.title }}
              </option>
            </template>
          </select>
        </td>
        <td>
          <select class="form-control" v-if="availableFilters.includes('client')" v-model="filter.client_id">
            <option :value="null">Filter by client</option>
            <template v-for="client in clientList" :key="client.id">
              <option :value="client.id">
                {{ client.company }}
              </option>
            </template>
          </select>
        </td>
        <td>
          <select class="form-control" v-if="availableFilters.includes('user')" v-model="filter.user_id">
            <option :value="null">Filter by user</option>
            <template v-for="user in userList" :key="user.id">
              <option :value="user.id">
                {{ user.name }}
              </option>
            </template>
          </select>
        </td>
        <td></td>
        <td></td>
        <td>
          <select class="form-control" v-if="availableFilters.includes('status')" v-model="filter.status_id">
            <option :value="null">Filter by status</option>
            <template v-for="(status, id) in statusList" :key="id">
              <option :value="id">
                {{ status }}
              </option>
            </template>
          </select>
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      </thead>
      <tbody>
      <template v-for="task in tasks" :key="task.id">
        <tr>
          <td>{{ task.id }}</td>
          <td>
            <router-link :to="{name: 'task.show', params: {id: task.id}}">
              {{ task.title }}
            </router-link>
          </td>
          <td>{{ task.project_title }}</td>
          <td>{{ task.project_client_company }}</td>
          <td v-html="task.project_user_name"></td>
          <td v-html="task.responses_count"></td>
          <td class="text-nowrap">
            <template v-if="task.last_response">
              <span v-html="task.last_response?.user_name"></span> / {{ task.last_response?.created_at }}
            </template>
          </td>
          <td>{{ task.status }}</td>
          <td class="text-nowrap">{{ task.created_at }}</td>
          <td class="text-nowrap">{{ task.updated_at }}</td>
          <td class="text-nowrap">
            <router-link class="btn btn-secondary btn-sm mr-1"
                         v-if="can('task-update') && !task.is_deleted"
                         :to="{name: 'task.edit', params: {id: task.id}}">
              <i class="cil-pencil"></i>
            </router-link>
            <button class="btn btn-light btn-sm mr-1"
                    v-if="can('task-delete') && !task.is_deleted"
                    @click="deleteTask(task.id)">
              <i class="cil-trash"></i>
            </button>
            <button class="btn btn-danger btn-sm"
                    v-if="can('task-restore') && task.is_deleted"
                    @click="recoverTask(task.id)">
              <i class="cil-reload"></i>
            </button>
          </td>
        </tr>
      </template>
      </tbody>
    </table>
  </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import {useRoute, useRouter} from "vue-router";
import {useAbility} from '@casl/vue';
import useTask from "../../composition/task";
import useProject from "../../composition/project";
import useUser from "../../composition/user";
import useClient from "../../composition/client";

export default {
  props: {
    tasks: {
      type: Object,
      required: true,
      default: []
    },
    availableFilters: {
      type: Array,
      default: []
    },
    deleteTask: {
      type: Function
    },
    recoverTask: {
      type: Function
    }
  },

  setup(props) {
    const route = useRoute()
    const router = useRouter()
    const {can} = useAbility();
    const {projectList, getProjectList} = useProject()
    const {clientList, getClientList} = useClient()
    const {userList, getUserList} = useUser()
    const {statusList, getStatusList} = useTask()
    const filter = ref({
      project_id: route.query.project_id ?? null,
      client_id: route.query.client_id ?? null,
      user_id: route.query.user_id ?? null,
      status_id: route.query.status_id ?? null,
    })

    const cleanFilter = (filter) => {
      return Object.keys(filter)
          .filter((k) => filter[k] != null)
          .reduce((a, k) => ({...a, [k]: filter[k]}), {})
    }

    onMounted(() => {
      if (props.availableFilters.includes('project')) getProjectList()
      if (props.availableFilters.includes('user')) getUserList()
      if (props.availableFilters.includes('client')) getClientList()
      if (props.availableFilters.includes('status')) getStatusList()
    })

    watch(filter.value, (filter) => {
      router.push({
        path: route.path,
        query: cleanFilter(filter)
      })
    })

    return {
      can,
      projectList,
      clientList,
      userList,
      statusList,
      filter
    }
  }
}
</script>