<template>
  <div class="table-responsive">
    <table class="table table-borderless table-hover">
      <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Task</th>
        <th>Client</th>
        <th>User</th>
        <th>Status</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Actions</th>
      </tr>
      </thead>
      <template v-for="task in tasks" :key="task.id">
        <tr>
          <td>{{ task.id }}</td>
          <td>{{ task.title }}</td>
          <td>{{ task.project }}</td>
          <td>{{ task.client }}</td>
          <td>{{ task.user }}</td>
          <td>{{ task.status }}</td>
          <td>{{ task.created_at }}</td>
          <td>{{ task.updated_at }}</td>
          <td class="text-nowrap">
            <router-link class="btn btn-secondary btn-sm mr-1" :to="{name: 'task.edit', params: {id: task.id}}"
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
    </table>
  </div>
</template>

<script>
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
  }
}
</script>