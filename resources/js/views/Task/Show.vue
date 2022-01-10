<template>
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
              <dd>{{ task.project }}</dd>
              <dt>Client</dt>
              <dd>{{ task.client }}</dd>
              <dt>Assigned user</dt>
              <dd>{{ task.user }}</dd>
              <dt>Status</dt>
              <dd>{{ task.status }}</dd>
            </dl>
          </div>
        </div>
        <TaskMedia :media="task.media"/>
        <TaskResponse v-for="response in task.responses" :key="response.id" :response="response"/>
      </div>
    </div>
  </div>
</template>

<script>
import useTask from "../../composition/task";
import useCrudAlert from "../../composition/crudalert";
import CrudAlert from "../../components/UI/CrudAlert";
import TaskMedia from "../../components/Task/Media";
import TaskResponse from "../../components/Task/Response";
import {onMounted} from "vue";

export default {
  components: {
    CrudAlert,
    TaskMedia,
    TaskResponse,
  },
  props: {
    id: {
      required: true,
      type: String
    }
  },

  setup(props) {
    const {task, errors, getTask} = useTask()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    onMounted(() => {
      getTask(props.id)
    })

    return {
      crudEvent,
      crudEventText,
      alertType,
      task,
      errors,
    }
  }
}
</script>