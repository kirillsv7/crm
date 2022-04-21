<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Task edit</div>
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
import {onMounted} from "vue"
import useTask from "../../composition/task";
import useCrudAlert from "../../composition/crudalert";
import TaskForm from "../../components/Task/Form";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    TaskForm,
    CrudAlert
  },
  props: {
    id: {
      required: true,
      type: String
    },
    created: {
      required: false,
      type: Boolean,
    },
  },

  setup(props) {
    const {task, errors, getTask, updateTask} = useTask()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const saveTask = async () => {
      crudEvent.value = 'updating'
      crudEventText.value = 'Updating task...'
      alertType.value = 'info'
      try {
        await updateTask(props.id)
        crudEvent.value = 'updated'
        crudEventText.value = 'Task updated!'
        alertType.value = 'success'
      } catch (e) {
        crudEvent.value = 'error'
        crudEventText.value = e.message
        alertType.value = 'danger'
      }
    }

    const toggleCreatedAlert = async () => {
      if (props.created) {
        crudEvent.value = 'created'
        crudEventText.value = 'Task created!'
      }
    }

    onMounted(() => {
      getTask(props.id)
      toggleCreatedAlert()
    })

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