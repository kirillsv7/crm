<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
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
import {onMounted, reactive, ref} from "vue";
import useTask from "../../composition/task";
import AlertElement from "../UI/AlertElement";

export default {
  components: {
    AlertElement
  },

  props: {
    encryptedId: {
      default: '',
      required: true,
      type: String
    }
  },

  emits: ['responseAdded'],

  setup(props, context) {
    const {errors, addResponse} = useTask()
    const taskResponse = reactive({})
    const alertMessage = ref('')
    const alertClass = ref('')
    const sending = ref(false)

    const sendResponse = async () => {
      sending.value = true
      try {
        alertMessage.value = 'Adding response...'
        alertClass.value = 'info'
        await addResponse(taskResponse)
        alertMessage.value = 'Response added!'
        alertClass.value = 'success'
        taskResponse.content = ''
        context.emit('responseAdded')
      } catch (e) {
        alertMessage.value = e.message
        alertClass.value = 'danger'
      }
      sending.value = false
    }

    onMounted(() => {
      taskResponse.task_id = props.encryptedId
    })

    return {
      alertMessage,
      alertClass,
      taskResponse,
      errors,
      sending,
      sendResponse
    }
  }
}
</script>