<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
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
import {onMounted, watch} from "vue";
import {useRoute} from "vue-router"
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
    const {users, pagination, getUsers, destroyUser} = useUser()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const deleteUser = async (id) => {
      crudEvent.value = null
      if (!window.confirm('Are you sure you want to delete?')) return
      await destroyUser(id);
      await getUsers();
      crudEvent.value = 'deleted'
      crudEventText.value = 'User deleted!'
      alertType.value = 'warning'
    }

    onMounted(getUsers)

    watch(
        () => route.query.page,
        getUsers
    )

    return {
      crudEvent,
      crudEventText,
      alertType,
      users,
      pagination,
      deleteUser
    }
  }
}
</script>