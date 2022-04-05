<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Task deleted
          </div>
          <div class="card-body">
            <TaskTable :tasks="tasksDeleted" :recoverTask="recoverTask"/>
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
import useCrudAlert from "../../composition/crudalert";
import TaskTable from "../../components/Task/Table";
import PaginationElement from "../../components/UI/PaginationElement";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    TaskTable,
    PaginationElement,
    CrudAlert
  },

  setup() {
    const route = useRoute()
    const {tasksDeleted, pagination, getTasksDeleted, restoreTask} = useTask()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const recoverTask = async (id) => {
      crudEvent.value = null
      if (!window.confirm('Are you sure you want to restore?')) return
      await restoreTask(id);
      await getTasksDeleted();
      crudEvent.value = 'restored'
      crudEventText.value = 'Task restored!'
      alertType.value = 'warning'
    }

    onMounted(getTasksDeleted(route.query))

    watch(() => route.query, getTasksDeleted)

    return {
      crudEvent,
      crudEventText,
      alertType,
      tasksDeleted,
      pagination,
      recoverTask
    }
  }
}
</script>