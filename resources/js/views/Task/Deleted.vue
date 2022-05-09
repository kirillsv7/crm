<template>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Task deleted
          </div>
          <div class="card-body">
            <TaskTable
                :tasks="tasks"
                :availableFilters="['project','client', 'user', 'status']"
                :restoreTask="restoreTask"
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
import {useRoute} from "vue-router";
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
    const {tasks, pagination, getTasksDeleted, restoreTask} = useTask()

    onMounted(getTasksDeleted)

    watch(() => route.query, getTasksDeleted)

    return {
      tasks,
      pagination,
      restoreTask
    }
  }
}
</script>