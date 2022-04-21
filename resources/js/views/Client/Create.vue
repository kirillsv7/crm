<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
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
import ClientForm from "../../components/Client/Form";
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    ClientForm,
    AlertElement
  },

  setup() {
    const {errors, storeClient} = useClient()
    const client = ref({
      'company': '',
      'vat': '',
      'address': '',
    })
    const alertMessage = ref('')
    const alertClass = ref('')

    const saveClient = async () => {
      alertMessage.value = 'Creating client...'
      alertClass.value = 'info'
      await storeClient({...client.value})
      if (Object.keys(errors.value).length !== 0) {
        alertMessage.value = 'Check fields!'
        alertClass.value = 'danger'
      }
    }

    return {
      alertMessage,
      alertClass,
      client,
      errors,
      saveClient
    }
  }
}
</script>