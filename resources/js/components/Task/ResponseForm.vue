<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
  <div class="card">
    <div class="card-header">Add response</div>
    <div class="card-body">
      <form id="response-form" enctype="multipart/form-data" @submit.prevent="sendResponse">
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
          <FileUpload :model="taskResponse" :saved="saved"/>
        </div>
        <button class="btn btn-primary" type="submit" :disabled="sending">{{ sending ? 'Sending...' : 'Send' }}</button>
      </form>
    </div>
  </div>
</template>

<script>
import {onMounted, ref} from "vue";
import AlertElement from "../UI/AlertElement";
import FileUpload from "../UI/Form/FileUpload";
import useTask from "../../composition/task";

export default {
  components: {
    AlertElement,
    FileUpload
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
    const taskResponse = ref({})
    const alertMessage = ref('')
    const alertClass = ref('')
    const sending = ref(false)
    const saved = ref(null)

    const sendResponse = async () => {
      sending.value = true
      try {
        alertMessage.value = 'Adding response...'
        alertClass.value = 'info'
        await addResponse(taskResponse)
        saved.value = Date.now()
        alertMessage.value = 'Response added!'
        alertClass.value = 'success'
        taskResponse.value.content = ''
        context.emit('responseAdded')
      } catch (e) {
        alertMessage.value = e.message
        alertClass.value = 'danger'
      }
      sending.value = false
    }

    onMounted(() => {
      taskResponse.value.task_id = props.encryptedId
    })

    return {
      alertMessage,
      alertClass,
      taskResponse,
      errors,
      sending,
      saved,
      sendResponse
    }
  }
}
</script>