<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">User create</div>
          <div class="card-body">
            <UserForm
                :user="user"
                :errors="errors"
                :saveUser="saveUser"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {ref} from "vue";
import useUser from "../../composition/user";
import useCrudAlert from "../../composition/crudalert";
import UserForm from "../../components/User/Form";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    UserForm,
    CrudAlert
  },

  setup() {
    const {errors, storeUser} = useUser()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()
    const user = ref({
      'name': '',
      'email': '',
      'password': '',
      'password_confirmation': '',
    })

    const saveUser = async () => {
      crudEvent.value = 'creating'
      crudEventText.value = 'Creating user...'
      alertType.value = 'info'
      await storeUser({...user.value})
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
      user,
      errors,
      saveUser
    }
  }
}
</script>