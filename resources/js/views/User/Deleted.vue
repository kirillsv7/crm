<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            User deleted
          </div>
          <div class="card-body">
            <UserTable :users="usersDeleted" :recover-user="recoverUser"/>
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
import {useRoute} from "vue-router";
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
    const {usersDeleted, pagination, getUsersDeleted, restoreUser} = useUser()
    const alertMessage = ref('')
    const alertClass = ref('')

    const recoverUser = async (id) => {
      if (!window.confirm('Are you sure you want to restore?')) return
      await restoreUser(id);
      await getUsersDeleted();
      alertMessage.value = 'User restored!'
      alertClass.value = 'warning'
    }

    onMounted(getUsersDeleted)

    watch(
        () => route.query.page,
        getUsersDeleted
    )

    return {
      alertMessage,
      alertClass,
      usersDeleted,
      pagination,
      recoverUser
    }
  }
}
</script>