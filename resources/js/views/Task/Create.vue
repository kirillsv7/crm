<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Task create</div>
          <div class="card-body">
            <TaskForm
                :task="task"
                :errors="errors"
                :saveTask="saveTask"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {inject} from "vue";
import useTask from "../../composition/task";
import TaskForm from "../../components/Task/Form";

export default {
  components: {
    TaskForm
  },

  setup() {
    const {task, errors, storeTask} = useTask()
    const alertMessage = inject('alertMessage')
    const alertClass = inject('alertClass')

    const saveTask = async () => {
      alertMessage.value = 'Creating task...'
      alertClass.value = 'info'
      try {
        await storeTask(task.value)
      } catch (e) {
        alertMessage.value = e.message
        alertClass.value = 'danger'
      }
    }

    return {
      task,
      errors,
      saveTask
    }
  }
}
</script>