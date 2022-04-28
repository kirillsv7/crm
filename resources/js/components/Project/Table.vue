<template>
  <div class="table-responsive">
    <table class="table table-borderless table-hover">
      <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Deadline</th>
        <th>Client</th>
        <th>User</th>
        <th>Tasks</th>
        <th>Status</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Actions</th>
      </tr>
      </thead>
      <template v-for="project in projects" :key="project.id">
        <tr>
          <td>{{ project.id }}</td>
          <td>
            <router-link :to="{name: 'project.show', params: {id: project.id}}">
              {{ project.title }}
            </router-link>
          </td>
          <td>{{ project.deadline }}</td>
          <td>{{ project.client_company }}</td>
          <td v-html="project.user_name"></td>
          <td>{{ project.tasks_count }}</td>
          <td>{{ project.status }}</td>
          <td>{{ project.created_at }}</td>
          <td>{{ project.updated_at }}</td>
          <td class="text-nowrap">
            <router-link class="btn btn-secondary btn-sm mr-1" :to="{name: 'project.edit', params: {id: project.id}}"
                         v-if="!project.is_deleted">
              <i class="cil-pencil"></i>
            </router-link>
            <button class="btn btn-light btn-sm mr-1" @click="deleteProject(project.id)" v-if="!project.is_deleted">
              <i class="cil-trash"></i>
            </button>
            <button class="btn btn-danger btn-sm" @click="recoverProject(project.id)" v-if="project.is_deleted">
              <i class="cil-reload"></i>
            </button>
          </td>
        </tr>
      </template>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    projects: {
      default: [],
      required: true,
      type: Object
    },
    deleteProject: {
      type: Function
    },
    recoverProject: {
      type: Function
    }
  }
}
</script>