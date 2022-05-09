<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            Task edit
            <router-link
                class="btn btn-primary ml-3"
                :to="{name: 'task.show', params: {id}}">
              <i class="cil-magnifying-glass"></i>
              Show task
            </router-link>
          </div>
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
import {onMounted} from "vue"
import useTask from "../../composition/task";
import TaskForm from "../../components/Task/Form";
import MediaElement from "../../components/UI/MediaElement";

export default {
  components: {
    TaskForm,
    MediaElement
  },
  props: {
    id: {
      required: true,
      type: String
    },
    created: {
      required: false,
      type: String,
      default: ''
    },
  },

  setup(props) {
    const {task, saved, errors, getTask, updateTask} = useTask()

    const saveTask = async () => {
      await updateTask(props.id)
    }

    onMounted(getTask(props.id))

    return {
      task,
      errors,
      saved,
      getTask,
      saveTask
    }
  }
}
</script>