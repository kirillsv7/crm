<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
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
import UserForm from "../../components/User/Form";
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    UserForm,
    AlertElement
  },

  setup() {
    const {errors, storeUser} = useUser()
    const user = ref({
      'name': '',
      'email': '',
      'password': '',
      'password_confirmation': '',
    })
    const alertMessage = ref('')
    const alertClass = ref('')

    const saveUser = async () => {
      alertMessage.value = 'Creating user...'
      alertClass.value = 'info'
      await storeUser({...user.value})
      if (Object.keys(errors.value).length !== 0) {
        alertMessage.value = 'Check fields!'
        alertClass.value = 'danger'
      }
    }

    return {
      alertMessage,
      alertClass,
      user,
      errors,
      saveUser
    }
  }
}
</script>