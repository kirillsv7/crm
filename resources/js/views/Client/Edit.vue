<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-header">Client edit</div>
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
import {inject, onMounted} from "vue";
import useClient from "../../composition/client";
import ClientForm from "../../components/Client/Form";

export default {
  components: {
    ClientForm,
  },
  props: {
    id: {
      required: true,
      type: String
    },
    created: {
      required: false,
      type: Boolean,
    },
  },

  setup(props) {
    const {client, errors, getClient, updateClient} = useClient()
    const alertMessage = inject('alertMessage')
    const alertClass = inject('alertClass')

    const saveClient = async () => {
      alertMessage.value = 'Updating client...'
      alertClass.value = 'info'
      await updateClient(props.id)
      if (Object.keys(errors.value).length === 0) {
        alertMessage.value = 'Client updated!'
        alertClass.value = null
      } else {
        alertMessage.value = 'Check fields!'
        alertClass.value = 'danger'
      }
    }

    const toggleCreatedAlert = async () => {
      if (props.created) {
        alertMessage.value = 'Client created!'
      }
    }

    onMounted(() => {
      getClient(props.id)
      toggleCreatedAlert()
    })

    return {
      client,
      errors,
      saveClient
    }
  }
}
</script>