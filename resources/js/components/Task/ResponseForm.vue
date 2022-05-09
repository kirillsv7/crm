<template>
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
import FileUpload from "../UI/Form/FileUpload";
import useTask from "../../composition/task";

export default {
  components: {
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

  setup(props, {emit}) {
    const {saved, errors, taskResponse, addResponse} = useTask()
    const sending = ref(false)

    const sendResponse = async () => {
      sending.value = true
      await addResponse(emit)
      sending.value = false
    }

    onMounted(() => {
      taskResponse.value.task_id = props.encryptedId
    })

    return {
      taskResponse,
      errors,
      sending,
      saved,
      sendResponse
    }
  }
}
</script>