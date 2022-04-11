<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
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
import useTask from "../../composition/task";
import useCrudAlert from "../../composition/crudalert";
import TaskForm from "../../components/Task/Form";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    TaskForm,
    CrudAlert
  },

  setup() {
    const {task, errors, storeTask} = useTask()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const saveTask = async () => {
      crudEvent.value = 'creating'
      crudEventText.value = 'Creating task...'
      alertType.value = 'info'
      await storeTask(task.value)
      if (Object.keys(errors.value).length !== 0) {
        crudEvent.value = 'error'
        crudEventText.value = 'Check fields!'
        alertType.value = 'danger'
      }
    }

    return {
      crudEvent,
      crudEventText,
      alertType,
      task,
      errors,
      saveTask
    }
  }
}
</script>