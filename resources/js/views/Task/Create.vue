<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
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
import {onBeforeMount, ref} from "vue";
import {useRouter} from "vue-router";
import {useAbility} from "@casl/vue"
import useTask from "../../composition/task";
import TaskForm from "../../components/Task/Form";
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    TaskForm,
    AlertElement
  },

  setup() {
    const router = useRouter()
    const {can} = useAbility()
    const {task, errors, storeTask} = useTask()
    const alertMessage = ref('')
    const alertClass = ref('')

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

    const checkUserCan = () => {
      if (!can('task-create'))
        router.push({
          name: 'task.index',
          params: {
            alertMessage: 'Not authorized!',
            alertClass: 'danger'
          }
        })
    }

    onBeforeMount(checkUserCan)

    return {
      alertMessage,
      alertClass,
      task,
      errors,
      saveTask
    }
  }
}
</script>