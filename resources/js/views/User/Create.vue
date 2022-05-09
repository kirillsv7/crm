<template>
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
import {inject} from "vue";
import useUser from "../../composition/user";
import UserForm from "../../components/User/Form";

export default {
  components: {
    UserForm,
  },

  setup() {
    const {user, errors, storeUser} = useUser()
    const alertMessage = inject('alertMessage')
    const alertClass = inject('alertClass')

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
      user,
      errors,
      saveUser
    }
  }
}
</script>