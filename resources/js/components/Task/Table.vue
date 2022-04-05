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
        <th>Status</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Actions</th>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>
          <select class="form-control" v-model="filter.project_id">
            <option :value="null">Filter by project</option>
            <template v-for="project in projectList" :key="project.id">
              <option :value="project.id">
                {{ project.title }}
              </option>
            </template>
          </select>
        </td>
        <td>
          <select class="form-control" v-model="filter.client_id">
            <option :value="null">Filter by client</option>
            <template v-for="client in clientList" :key="client.id">
              <option :value="client.id">
                {{ client.company }}
              </option>
            </template>
          </select>
        </td>
        <td>
          <select class="form-control" v-model="filter.user_id">
            <option :value="null">Filter by user</option>
            <template v-for="user in userList" :key="user.id">
              <option :value="user.id">
                {{ user.name }}
              </option>
            </template>
          </select>
        </td>
        <td>
          <select class="form-control" v-model="filter.status_id">
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
          <td>{{ task.project }}</td>
          <td>{{ task.client }}</td>
          <td>{{ task.user }}</td>
          <td>{{ task.status }}</td>
          <td>{{ task.created_at }}</td>
          <td>{{ task.updated_at }}</td>
          <td class="text-nowrap">
            <router-link class="btn btn-secondary btn-sm mr-1"
                         :to="{name: 'task.edit', params: {id: task.id}}"
                         v-if="!task.deleted">
              <i class="cil-pencil"></i>
            </router-link>
            <button class="btn btn-light btn-sm mr-1" @click="deleteTask(task.id)" v-if="!task.deleted">
              <i class="cil-trash"></i>
            </button>
            <button class="btn btn-danger btn-sm" @click="recoverTask(task.id)" v-if="task.deleted">
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
import useTask from "../../composition/task";
import useProject from "../../composition/project";
import useUser from "../../composition/user";
import useClient from "../../composition/client";

export default {
  props: {
    tasks: {
      default: [],
      required: true,
      type: Object
    },
    deleteTask: {
      type: Function
    },
    recoverTask: {
      type: Function
    }
  },

  setup() {
    const route = useRoute()
    const router = useRouter()
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

    onMounted(() => {
      getProjectList()
      getUserList()
      getClientList()
      getStatusList()
    })

    watch(filter.value, (filter) => {
      const validFilter = Object.keys(filter)
          .filter((k) => filter[k] != null)
          .reduce((a, k) => ({...a, [k]: filter[k]}), {})
      router.push({
        path: route.path,
        query: validFilter
      })
    })

    return {
      projectList,
      clientList,
      userList,
      statusList,
      filter
    }
  }
}
</script>