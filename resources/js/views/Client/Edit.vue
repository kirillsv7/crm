<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
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
import {onMounted} from "vue";
import useClient from "../../composition/client";
import useCrudAlert from "../../composition/crudalert";
import ClientForm from "../../components/Client/Form";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    ClientForm,
    CrudAlert
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
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const saveClient = async () => {
      crudEvent.value = null
      await updateClient(props.id)
      if (Object.keys(errors.value).length === 0) {
        crudEvent.value = 'updated'
        crudEventText.value = 'Client updated!'
        alertType.value = null
      } else {
        crudEvent.value = 'error'
        crudEventText.value = 'Check fields!'
        alertType.value = 'danger'
      }
    }

    const toggleCreatedAlert = async () => {
      if (props.created) {
        crudEvent.value = 'created'
        crudEventText.value = 'Client created!'
      }
    }

    onMounted(() => {
      getClient(props.id)
      toggleCreatedAlert()
    })

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