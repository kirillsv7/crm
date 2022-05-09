<template>
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
import {inject} from "vue";
import useClient from "../../composition/client";
import ClientForm from "../../components/Client/Form";

export default {
  components: {
    ClientForm,
  },

  setup() {
    const {client, errors, storeClient} = useClient()
    const alertMessage = inject('alertMessage')
    const alertClass = inject('alertClass')

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
      client,
      errors,
      saveClient
    }
  }
}
</script>