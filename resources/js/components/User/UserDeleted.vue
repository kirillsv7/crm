<template>
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
          <div class="card-footer">
            <div class="d-flex justify-content-center">
              <PaginationElement :pagination="pagination"/>
            </div>
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
import UserTable from "./UserTable";
import PaginationElement from "../UI/PaginationElement"

export default {
  name: 'UserDeleted',

  components: {
    UserTable,
    PaginationElement
  },

  setup() {
    const route = useRoute()
    const {usersDeleted, pagination, getUsersDeleted, restoreUser} = useUser()

    const recoverUser = async (id) => {
      if (!window.confirm('Are you sure you want to restore?')) {
        return
      }

      await restoreUser(id);
      await getUsersDeleted();
    }

    onMounted(getUsersDeleted)

    watch(
        () => route.query.page,
        getUsersDeleted
    )

    return {
      usersDeleted,
      pagination,
      recoverUser
    }
  }
}
</script>