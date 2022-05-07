<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center">
            <span>Task list</span>
            <router-link
                class="btn btn-primary ml-3"
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
import {onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router"
import {useAbility} from '@casl/vue';
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
  props: {
    alertMessage: {
      required: false,
      type: String,
      default: ''
    },
    alertClass: {
      required: false,
      type: String,
      default: ''
    },
  },

  setup(props) {
    const route = useRoute()
    const {can} = useAbility();
    const {tasks, pagination, getTasks, destroyTask} = useTask()
    const alertMessage = ref('')
    const alertClass = ref('')

    const deleteTask = async (id) => {
      if (!window.confirm('Are you sure you want to delete?')) return
      alertMessage.value = 'Deleting task...'
      alertClass.value = 'info'
      await destroyTask(id);
      alertMessage.value = 'Task deleted!'
      alertClass.value = 'success'
    }

    onMounted(() => {
      alertMessage.value = props.alertMessage
      alertClass.value = props.alertClass
      getTasks()
    })

    watch(() => route.query, getTasks)

    return {
      can,
      alertMessage,
      alertClass,
      tasks,
      pagination,
      deleteTask
    }
  }
}
</script>