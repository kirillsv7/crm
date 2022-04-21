<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Client list
          </div>
          <div class="card-body">
            <ClientTable :clients="clients" :delete-client="deleteClient"/>
          </div>
          <div class="card-footer d-flex justify-content-center">
            <PaginationElement :pagination="pagination"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router"
import useClient from "../../composition/client";
import ClientTable from "../../components/Client/Table";
import PaginationElement from "../../components/UI/PaginationElement";
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    ClientTable,
    PaginationElement,
    AlertElement
  },

  setup() {
    const route = useRoute()
    const {clients, pagination, getClients, destroyClient} = useClient()
    const alertMessage = ref('')
    const alertClass = ref('')

    const deleteClient = async (id) => {
      if (!window.confirm('Are you sure you want to delete?')) return
      await destroyClient(id);
      await getClients();
      alertMessage.value = 'Client deleted!'
      alertClass.value = 'warning'
    }

    onMounted(getClients)

    watch(
        () => route.query.page,
        getClients
    )

    return {
      alertMessage,
      alertClass,
      clients,
      pagination,
      deleteClient
    }
  }
}
</script>