<template>
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
import UserTable from "./UserTable"
import PaginationElement from "../UI/PaginationElement"

export default {
  name: 'UserIndex',

  components: {
    UserTable,
    PaginationElement
  },

  setup() {
    const route = useRoute()
    const {users, pagination, getUsers, destroyUser} = useUser()

    const deleteUser = async (id) => {
      if (!window.confirm('Are you sure you want to delete?')) {
        return
      }

      await destroyUser(id);
      await getUsers();
    }

    onMounted(getUsers)

    watch(
        () => route.query.page,
        getUsers
    )

    return {
      users,
      pagination,
      deleteUser
    }
  }
}
</script>