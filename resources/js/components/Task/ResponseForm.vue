<template>
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
import useTask from "../../composition/task";
import {inject, onMounted, ref} from "vue";

export default {
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
    const taskResponse = ref({
      task_id: '',
      content: ''
    })
    const sending = ref(false)

    const sendResponse = async () => {
      sending.value = true
      const response = await addResponse({...taskResponse.value})
      if (Object.keys(errors.value).length === 0) {
        task.value.responses.push(response)
        taskResponse.value.content = ''
      }
      sending.value = false
    }

    onMounted(() => {
      taskResponse.value.task_id = props.encryptedId
    })

    return {
      taskResponse,
      errors,
      sending,
      sendResponse
    }
  }
}
</script>