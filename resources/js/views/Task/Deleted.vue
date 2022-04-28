<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
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
                :recoverTask="recoverTask"
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
import {onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router";
import useTask from "../../composition/task";
import TaskTable from "../../components/Task/Table";
import PaginationElement from "../../components/UI/PaginationElement";
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    TaskTable,
    PaginationElement,
    AlertElement
  },

  setup() {
    const route = useRoute()
    const {tasks, pagination, getTasksDeleted, restoreTask} = useTask()
    const alertMessage = ref('')
    const alertClass = ref('')

    const recoverTask = async (id) => {
      if (!window.confirm('Are you sure you want to restore?')) return
      alertMessage.value = 'Restoring task...'
      alertClass.value = 'info'
      await restoreTask(id);
      alertMessage.value = 'Task restored!'
      alertClass.value = 'success'
    }

    onMounted(getTasksDeleted)

    watch(() => route.query, getTasksDeleted)

    return {
      alertMessage,
      alertClass,
      tasks,
      pagination,
      recoverTask
    }
  }
}
</script>