<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">User edit</div>
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
import {onMounted, ref} from "vue";
import useUser from "../../composition/user";
import UserForm from "../../components/User/Form";
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    UserForm,
    AlertElement
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
    const {user, errors, getUser, updateUser} = useUser()
    const alertMessage = ref('')
    const alertClass = ref('')

    const saveUser = async () => {
      alertMessage.value = 'Updating user...'
      alertClass.value = 'info'
      await updateUser(props.id)
      if (Object.keys(errors.value).length === 0) {
        alertMessage.value = 'User updated!'
        alertClass.value = null
      } else {
        alertMessage.value = 'Check fields!'
        alertClass.value = 'danger'
      }
    }

    const toggleCreatedAlert = async () => {
      if (props.created) {
        alertMessage.value = 'User created!'
      }
    }

    onMounted(() => {
      getUser(props.id)
      toggleCreatedAlert()
    })

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