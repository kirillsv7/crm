<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-header">
            Task details
            <router-link
                class="btn btn-primary ms-3"
                v-if="can('task-update') && !task.is_deleted"
                :to="{name: 'task.edit', params: {id}}">
              <i class="cil-pencil"></i>
              Edit task
            </router-link>
          </div>
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
          <ResponseForm
              v-if="task.encrypted_id"
              :encryptedId="task.encrypted_id"
              @responseAdded="refreshResponses"
          />
        </template>
        <div class="d-flex justify-content-center mb-3" v-if="pagination.last_page > 1">
          <PaginationElement :pagination="pagination"/>
        </div>
        <template v-if="responses.length">
          <TaskResponse
              v-for="response in responses"
              :key="response.id" :response="response"
              :class="{'border border-primary': response.id === addedResponse}"
              @responseDeleted="getResponsesByTask(id)"
          />
        </template>
        <template v-else>
          <div class="card m-0">
            <div class="card-body">
              <div class="text-center">Task hasn't responses yet</div>
            </div>
          </div>
        </template>
        <div class="d-flex justify-content-center mb-3" v-if="pagination.last_page > 1">
          <PaginationElement :pagination="pagination"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import {useRoute, useRouter} from "vue-router";
import {useAbility} from '@casl/vue';
import useTask from "../../composition/task";
import useResponse from "../../composition/response";
import MediaElement from "../../components/UI/MediaElement";
import TaskResponse from "../../components/Task/Response";
import ResponseForm from "../../components/Task/ResponseForm";
import PaginationElement from "../../components/UI/PaginationElement";

export default {
  components: {
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
    const {can} = useAbility();
    const {task, getTask} = useTask()
    const {responses, pagination, getResponsesByTask} = useResponse()
    const addedResponse = ref(null)

    const refreshResponses = (addedResponseId) => {
      addedResponse.value = addedResponseId
      getResponsesByTask(props.id)
      router.push(route.path)
    }

    onMounted(() => {
      getTask(props.id)
      getResponsesByTask(props.id)
    })

    watch(() => route.query, () => getResponsesByTask(props.id))

    return {
      can,
      task,
      responses,
      pagination,
      addedResponse,
      getResponsesByTask,
      refreshResponses
    }
  }
}
</script>