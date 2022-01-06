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
import {ref} from "vue"
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
    const {errors, storeTask} = useTask()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()
    const task = ref({
      'title': '',
      'description': '',
      'deadline': '',
      'client_id': '',
      'user_id': '',
      'status_id': ''
    })

    const saveTask = async () => {
      crudEvent.value = null
      await storeTask({...task.value})
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