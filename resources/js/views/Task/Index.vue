<template>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header">
            Task list
            <router-link
                class="btn btn-primary ms-3"
                v-if="can('task-create')"
                :to="{name:'task.create'}">
              <i class="cil-plus"></i>
              Add task
            </router-link>
          </div>
          <div class="card-body">
            <TaskTable
                :tasks="tasks"
                :availableFilters="['project','client', 'user', 'status']"
                :deleteTask="deleteTask"
            />
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
import {useAbility} from '@casl/vue';
import useTask from "../../composition/task";
import TaskTable from "../../components/Task/Table";
import PaginationElement from "../../components/UI/PaginationElement";

export default {
  components: {
    TaskTable,
    PaginationElement,
  },

  setup() {
    const route = useRoute()
    const {can} = useAbility();
    const {tasks, pagination, getTasks, deleteTask} = useTask()

    onMounted(getTasks)

    watch(() => route.query, getTasks)

    return {
      can,
      tasks,
      pagination,
      deleteTask
    }
  }
}
</script>