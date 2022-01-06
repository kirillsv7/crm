<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Task list
          </div>
          <div class="card-body">
            <TaskTable :tasks="tasks" :deleteTask="deleteTask"/>
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
    const {tasks, pagination, getTasks, destroyTask} = useTask()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const deleteTask = async (id) => {
      crudEvent.value = null
      if (!window.confirm('Are you sure you want to delete?')) return
      await destroyTask(id);
      await getTasks();
      crudEvent.value = 'deleted'
      crudEventText.value = 'Task deleted!'
      alertType.value = 'warning'
    }

    onMounted(getTasks)

    watch(
        () => route.query.page,
        getTasks
    )

    return {
      crudEvent,
      crudEventText,
      alertType,
      tasks,
      pagination,
      deleteTask
    }
  }
}
</script>