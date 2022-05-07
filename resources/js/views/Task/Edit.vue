<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Task edit</div>
          <div class="card-body">
            <TaskForm
                :task="task"
                :errors="errors"
                :saved="saved"
                :saveTask="saveTask"
            />
          </div>
        </div>
        <MediaElement :media="task.media" @mediaDeleted="getTask(id)"/>
      </div>
    </div>
  </div>
</template>

<script>
import {onBeforeMount, onMounted, ref} from "vue"
import {useRouter} from "vue-router";
import {useAbility} from "@casl/vue"
import useTask from "../../composition/task";
import AlertElement from "../../components/UI/AlertElement";
import TaskForm from "../../components/Task/Form";
import MediaElement from "../../components/UI/MediaElement";

export default {
  components: {
    TaskForm,
    AlertElement,
    MediaElement
  },
  props: {
    id: {
      required: true,
      type: String
    },
    created: {
      required: false,
      type: Boolean,
      default: false
    },
  },

  setup(props) {
    const router = useRouter()
    const {can} = useAbility()
    const {task, errors, getTask, updateTask} = useTask()
    const alertMessage = ref('')
    const alertClass = ref('')
    const saved = ref(null)

    const saveTask = async () => {
      alertMessage.value = 'Updating task...'
      alertClass.value = 'info'
      try {
        await updateTask(props.id)
        saved.value = Date.now()
        alertMessage.value = 'Task updated!'
        alertClass.value = 'success'
      } catch (e) {
        alertMessage.value = e.message
        alertClass.value = 'danger'
      }
    }

    const toggleCreatedAlert = async () => {
      if (props.created) {
        alertMessage.value = 'Task created!'
      }
    }

    onBeforeMount(() => {
      if (!can('task-update'))
        router.push({
          name: 'task.index',
          params: {
            alertMessage: 'Not authorized!',
            alertClass: 'danger'
          }
        })
    })

    onMounted(() => {
      getTask(props.id)
      toggleCreatedAlert()
    })

    return {
      alertMessage,
      alertClass,
      task,
      errors,
      saved,
      getTask,
      saveTask
    }
  }
}
</script>