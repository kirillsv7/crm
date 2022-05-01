<template>
  <AlertElement :alertMessage="alertMessage"/>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Task details</div>
          <div class="card-body">
            <dl>
              <dt>Title</dt>
              <dd>{{ task.title }}</dd>
              <dt>Description</dt>
              <dd>{{ task.description }}</dd>
              <dt>Project</dt>
              <dd>{{ task.project_title }}</dd>
              <dt>Client</dt>
              <dd>{{ task.project_client_company }}</dd>
              <dt>Assigned user</dt>
              <dd v-html="task.project_user_name"></dd>
              <dt>Status</dt>
              <dd>{{ task.status }}</dd>
            </dl>
          </div>
        </div>
        <MediaElement :media="task.media"/>
        <template v-if="!task.deleted">
          <ResponseForm v-if="task.encrypted_id" :encryptedId="task.encrypted_id" @responseAdded="refreshResponses"/>
        </template>
        <div class="d-flex justify-content-center mb-4">
          <PaginationElement :pagination="pagination"/>
        </div>
        <TaskResponse v-for="response in responses" :key="response.id" :response="response"/>
        <div class="d-flex justify-content-center mb-4">
          <PaginationElement :pagination="pagination"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import {useRoute, useRouter} from "vue-router";
import useTask from "../../composition/task";
import useResponse from "../../composition/response";
import AlertElement from "../../components/UI/AlertElement";
import MediaElement from "../../components/UI/MediaElement";
import TaskResponse from "../../components/Task/Response";
import ResponseForm from "../../components/Task/ResponseForm";
import PaginationElement from "../../components/UI/PaginationElement";

export default {
  components: {
    AlertElement,
    ResponseForm,
    MediaElement,
    TaskResponse,
    PaginationElement
  },
  props: {
    id: {
      required: true,
      type: String
    }
  },

  setup(props) {
    const route = useRoute()
    const router = useRouter()
    const {task, getTask} = useTask()
    const {responses, pagination, getResponsesByTask} = useResponse()
    const alertMessage = ref('')

    const refreshResponses = () => {
      getResponsesByTask(props.id)
      router.push(route.path)
    }

    onMounted(() => {
      getTask(props.id)
      getResponsesByTask(props.id)
    })

    watch(() => route.query, () => getResponsesByTask(props.id))

    return {
      alertMessage,
      task,
      responses,
      pagination,
      refreshResponses
    }
  }
}
</script>