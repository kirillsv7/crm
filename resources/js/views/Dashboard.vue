<template>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">Recent responses</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless table-hover">
                <thead>
                <tr>
                  <th>Content</th>
                  <th>User</th>
                  <th>Task</th>
                  <th>Created</th>
                </tr>
                </thead>
                <template v-for="response in responses" :key="response.id">
                  <tr>
                    <td>
                      <router-link
                          :to="{name: 'task.show', params: {id: response.task.id}, hash: '#response-' + response.id}">
                        {{ response.content }}
                      </router-link>
                    </td>
                    <td>{{ response.user.name }}</td>
                    <td>{{ response.task.title }}</td>
                    <td>{{ response.created_at }}</td>
                  </tr>
                </template>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">Tasks with new responses</div>
          <div class="card-body">
            <TaskTable :tasks="tasks"/>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">Projects with new tasks</div>
          <div class="card-body">
            <ProjectTable :projects="projects"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted} from "vue";
import useProject from "../composition/project";
import useTask from "../composition/task";
import useResponse from "../composition/response";
import ProjectTable from "../components/Project/Table"
import TaskTable from "../components/Task/Table"

export default {
  components: {
    ProjectTable,
    TaskTable
  },

  setup() {
    const {projects, getRecentlyAddedTask} = useProject()
    const {tasks, getRecentlyResponsed} = useTask()
    const {responses, getLatestResponses} = useResponse()

    onMounted(() => {
      getRecentlyAddedTask()
      getRecentlyResponsed()
      getLatestResponses()
    })

    return {
      projects,
      tasks,
      responses
    }
  }
}
</script>