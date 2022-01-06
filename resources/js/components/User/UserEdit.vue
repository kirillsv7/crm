<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
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
import UserForm from "./UserForm";
import CrudAlert from "../UI/CrudAlert";

export default {
  name: 'UserEdit',
  components: {
    UserForm,
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
    const crudEvent = ref('')
    const crudEventText = ref(null)
    const alertType = ref(null)
    const {user, errors, getUser, updateUser} = useUser()

    const saveUser = async () => {
      crudEvent.value = null
      await updateUser(props.id)
      if (Object.keys(errors.value).length === 0) {
        crudEvent.value = 'updated'
        crudEventText.value = 'User updated!'
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
        crudEventText.value = 'User created!'
      }
    }

    onMounted(() => {
      getUser(props.id)
      toggleCreatedAlert()
    })

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