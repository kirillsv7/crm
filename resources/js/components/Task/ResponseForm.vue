<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
  <div class="card">
    <div class="card-header">Add response</div>
    <div class="card-body">
      <form id="response-form" @submit.prevent="sendResponse">
        <input name="task_id" type="hidden"
               v-model="taskResponse.task_id">
        <div class="form-group">
          <label>Content</label>
          <textarea class="form-control" :class="{'is-invalid': errors.content}" name="content"
                    v-model="taskResponse.content"></textarea>
          <div class="invalid-feedback" v-if="errors.content">
            <template v-for="error in errors.content">
              {{ error }}
            </template>
          </div>
        </div>
        <div class="form-group">
          <label>Media upload</label>
          <div class="dropzone"></div>
        </div>
        <button class="btn btn-primary" type="submit" :disabled="sending">{{ sending ? 'Sending...' : 'Send' }}</button>
      </form>
    </div>
  </div>
</template>

<script>
import {inject, onMounted, ref} from "vue";
import useTask from "../../composition/task";
import useCrudAlert from "../../composition/crudalert";
import CrudAlert from "../UI/CrudAlert";

export default {
  components: {
    CrudAlert
  },

  props: {
    encryptedId: {
      default: '',
      required: true,
      type: String
    }
  },

  setup(props) {
    const task = inject('task')
    const {errors, addResponse} = useTask()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()
    const taskResponse = ref({
      task_id: '',
      content: ''
    })
    const sending = ref(false)

    const sendResponse = async () => {
      sending.value = true
      try {
        crudEvent.value = 'adding'
        crudEventText.value = 'Adding response...'
        alertType.value = 'info'
        const response = await addResponse(taskResponse.value)
        task.value.responses.push(response)
        taskResponse.value.content = ''
        crudEvent.value = 'added'
        crudEventText.value = 'Response added!'
        alertType.value = 'success'
      } catch (e) {
        crudEvent.value = 'error'
        crudEventText.value = e.message
        alertType.value = 'danger'
      }
      sending.value = false
    }

    onMounted(() => {
      taskResponse.value.task_id = props.encryptedId
    })

    return {
      crudEvent,
      crudEventText,
      alertType,
      taskResponse,
      errors,
      sending,
      sendResponse
    }
  }
}
</script>