<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
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
import {onMounted, watch} from "vue";
import {useRoute} from "vue-router"
import useClient from "../../composition/client";
import useCrudAlert from "../../composition/crudalert";
import ClientTable from "../../components/Client/Table";
import PaginationElement from "../../components/UI/PaginationElement";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    ClientTable,
    PaginationElement,
    CrudAlert
  },

  setup() {
    const route = useRoute()
    const {clients, pagination, getClients, destroyClient} = useClient()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const deleteClient = async (id) => {
      crudEvent.value = null
      if (!window.confirm('Are you sure you want to delete?')) return
      await destroyClient(id);
      await getClients();
      crudEvent.value = 'deleted'
      crudEventText.value = 'Client deleted!'
      alertType.value = 'warning'
    }

    onMounted(getClients)

    watch(
        () => route.query.page,
        getClients
    )

    return {
      crudEvent,
      crudEventText,
      alertType,
      clients,
      pagination,
      deleteClient
    }
  }
}
</script>