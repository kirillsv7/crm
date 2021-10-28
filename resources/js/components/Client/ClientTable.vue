<template>
  <div class="table-responsive">
    <table class="table table-borderless table-hover">
      <thead>
      <tr>
        <th>ID</th>
        <th>Company</th>
        <th>VAT</th>
        <th>Address</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Actions</th>
      </tr>
      </thead>
      <template v-for="client in clients" :key="client.id">
        <tr>
          <td>{{ client.id }}</td>
          <td>{{ client.company }}</td>
          <td>{{ client.vat }}</td>
          <td>{{ client.address }}</td>
          <td>{{ client.created_at }}</td>
          <td>{{ client.updated_at }}</td>
          <td class="text-nowrap">
            <router-link class="btn btn-secondary btn-sm mr-1" :to="{name: 'client.edit', params: {id: client.id}}"
                         v-if="!client.deleted">
              <i class="cil-pencil"></i>
            </router-link>
            <button class="btn btn-light btn-sm mr-1" @click="deleteClient(client.id)" v-if="!client.deleted">
              <i class="cil-trash"></i>
            </button>
            <button class="btn btn-danger btn-sm" @click="recoverClient(client.id)" v-if="client.deleted">
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
    clients: {
      default: [],
      required: true,
      type: Object
    },
    deleteClient: {
      type: Function
    },
    recoverClient: {
      type: Function
    }
  }
}
</script>