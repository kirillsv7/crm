<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
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
import {useRoute} from "vue-router";
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
    const {clientsDeleted, pagination, getClientsDeleted, restoreClient} = useClient()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const recoverClient = async (id) => {
      crudEvent.value = null
      if (!window.confirm('Are you sure you want to restore?')) return
      await restoreClient(id);
      await getClientsDeleted();
      crudEvent.value = 'restored'
      crudEventText.value = 'Client restored!'
      alertType.value = 'warning'
    }

    onMounted(getClientsDeleted)

    watch(
        () => route.query.page,
        getClientsDeleted
    )

    return {
      crudEvent,
      crudEventText,
      alertType,
      clientsDeleted,
      pagination,
      recoverClient
    }
  }
}
</script>