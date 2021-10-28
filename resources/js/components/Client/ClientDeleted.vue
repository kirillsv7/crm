<template>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Client deleted
          </div>
          <div class="card-body">
            <ClientTable :clients="clientsDeleted" :recover-client="recoverClient"/>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-center">
              <PaginationElement :pagination="pagination"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted, watch} from "vue";
import {useRoute} from "vue-router";
import useClient from "../../composition/client";
import ClientTable from "./ClientTable"
import PaginationElement from "../UI/PaginationElement"

export default {
  name: 'ClientDeleted',

  components: {
    ClientTable,
    PaginationElement
  },

  setup() {
    const route = useRoute()
    const {clientsDeleted, pagination, getClientsDeleted, restoreClient} = useClient()

    const recoverClient = async (id) => {
      if (!window.confirm('Are you sure you want to restore?')) {
        return
      }

      await restoreClient(id);
      await getClientsDeleted();
    }

    onMounted(getClientsDeleted)

    watch(
        () => route.query.page,
        getClientsDeleted
    )

    return {
      clientsDeleted,
      pagination,
      recoverClient
    }
  }
}
</script>