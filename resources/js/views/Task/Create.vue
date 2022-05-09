<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Task create</div>
          <div class="card-body">
            <TaskForm
                :task="task"
                :errors="errors"
                :saveTask="storeTask"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import useTask from "../../composition/task";
import TaskForm from "../../components/Task/Form";

export default {
  components: {
    TaskForm
  },

  setup() {
    const {task, errors, storeTask} = useTask()

    return {
      task,
      errors,
      storeTask
    }
  }
}
</script>