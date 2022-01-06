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
import UserForm from "./UserForm";
import CrudAlert from "../UI/CrudAlert";

export default {
  name: 'UserCreate',
  components: {
    UserForm,
    CrudAlert
  },

  setup() {
    const crudEvent = ref('')
    const crudEventText = ref(null)
    const alertType = ref(null)
    const {errors, storeUser} = useUser()
    const user = ref({
      'name': '',
      'email': '',
      'password': '',
      'password_confirmation': '',
    })

    const saveUser = async () => {
      crudEvent.value = null
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