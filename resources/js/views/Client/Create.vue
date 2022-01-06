<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Client create</div>
          <div class="card-body">
            <ClientForm
                :client="client"
                :errors="errors"
                :saveClient="saveClient"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {ref} from "vue";
import useClient from "../../composition/client";
import useCrudAlert from "../../composition/crudalert";
import ClientForm from "../../components/Client/Form";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    ClientForm,
    CrudAlert
  },

  setup() {
    const {errors, storeClient} = useClient()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()
    const client = ref({
      'company': '',
      'vat': '',
      'address': '',
    })

    const saveClient = async () => {
      crudEvent.value = null
      await storeClient({...client.value})
      if (Object.keys(errors.value).length !== 0) {
        crudEvent.value = 'error'
        crudEventText.value = 'Check fields!'
        alertType.value = 'danger'
      }
    }

    return {
      crudEvent,
      crudEventText,
      alertType,
      client,
      errors,
      saveClient
    }
  }
}
</script>