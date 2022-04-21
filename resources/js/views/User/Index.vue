<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            User list
          </div>
          <div class="card-body">
            <UserTable :users="users" :delete-user="deleteUser"/>
          </div>
          <div class="card-footer d-flex justify-content-center">
            <PaginationElement :pagination="pagination"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router"
import useUser from "../../composition/user";
import UserTable from "../../components/User/Table";
import PaginationElement from "../../components/UI/PaginationElement";
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    UserTable,
    PaginationElement,
    AlertElement
  },

  setup() {
    const route = useRoute()
    const {users, pagination, getUsers, destroyUser} = useUser()
    const alertMessage = ref('')
    const alertClass = ref('')

    const deleteUser = async (id) => {
      if (!window.confirm('Are you sure you want to delete?')) return
      await destroyUser(id);
      await getUsers();
      alertMessage.value = 'User deleted!'
      alertClass.value = 'warning'
    }

    onMounted(getUsers)

    watch(
        () => route.query.page,
        getUsers
    )

    return {
      alertMessage,
      alertClass,
      users,
      pagination,
      deleteUser
    }
  }
}
</script>