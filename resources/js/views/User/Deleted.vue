<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
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
import {onMounted, watch} from "vue";
import {useRoute} from "vue-router";
import useUser from "../../composition/user";
import useCrudAlert from "../../composition/crudalert";
import UserTable from "../../components/User/Table";
import PaginationElement from "../../components/UI/PaginationElement";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    UserTable,
    PaginationElement,
    CrudAlert
  },

  setup() {
    const route = useRoute()
    const {usersDeleted, pagination, getUsersDeleted, restoreUser} = useUser()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const recoverUser = async (id) => {
      crudEvent.value = null
      if (!window.confirm('Are you sure you want to restore?')) return
      await restoreUser(id);
      await getUsersDeleted();
      crudEvent.value = 'restored'
      crudEventText.value = 'User restored!'
      alertType.value = 'warning'
    }

    onMounted(getUsersDeleted)

    watch(
        () => route.query.page,
        getUsersDeleted
    )

    return {
      crudEvent,
      crudEventText,
      alertType,
      usersDeleted,
      pagination,
      recoverUser
    }
  }
}
</script>