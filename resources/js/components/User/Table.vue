<template>
  <div class="table-responsive">
    <table class="table table-borderless table-hover">
      <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Is admin</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      <template v-for="user in users" :key="user.id">
        <tr>
          <td>{{ user.id }}</td>
          <td v-html="user.name"></td>
          <td>{{ user.email }}</td>
          <td>
            <i :class="[user.is_admin ? 'cil-check-alt text-success' : 'cil-x text-muted']"></i>
          </td>
          <td>{{ user.created_at }}</td>
          <td>{{ user.updated_at }}</td>
          <td class="text-nowrap">
            <router-link class="btn btn-secondary btn-sm me-1" :to="{name: 'user.edit', params: {id: user.id}}"
                         v-if="!user.is_deleted">
              <i class="cil-pencil"></i>
            </router-link>
            <button class="btn btn-light btn-sm me-1" @click="deleteUser(user.id)" v-if="!user.is_deleted">
              <i class="cil-trash"></i>
            </button>
            <button class="btn btn-danger btn-sm" @click="recoverUser(user.id)" v-if="user.is_deleted">
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
export default {
  props: {
    users: {
      default: [],
      required: true,
      type: Object
    },
    deleteUser: {
      type: Function
    },
    recoverUser: {
      type: Function
    }
  }
}
</script>