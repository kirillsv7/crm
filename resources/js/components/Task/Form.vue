<template>
  <form id="project-form" @submit.prevent="saveTask">
    <div class="form-group">
      <label>Title</label>
      <input class="form-control" :class="{'is-invalid': errors.title}" name="title" type="text"
             v-model="task.title">
      <div class="invalid-feedback" v-if="errors.title">
        <template v-for="error in errors.title">
          {{ error }}
        </template>
      </div>
    </div>
    <div class="form-group">
      <label>Description</label>
      <textarea class="form-control" :class="{'is-invalid': errors.description}" name="description"
                v-model="task.description"></textarea>
      <div class="invalid-feedback" v-if="errors.description">
        <template v-for="error in errors.description">
          {{ error }}
        </template>
      </div>
    </div>
    <div class="form-group">
      <label>Project</label>
      <select class="form-control" :class="{'is-invalid': errors.project_id}" name="project_id"
              v-model="task.project_id">
        <option value="">Project</option>
        <template v-for="project in projectList" :key="project.id">
          <option :value="project.id">
            {{ project.title }}
          </option>
        </template>
      </select>
      <div class="invalid-feedback" v-if="errors.project_id">
        <template v-for="error in errors.project_id">
          {{ error }}
        </template>
      </div>
    </div>
    <div class="form-group">
      <label>Status</label>
      <select class="form-control" :class="{'is-invalid': errors.status_id}" name="status_id"
              v-model="task.status_id">
        <option value="">Select status</option>
        <template v-for="(status, key) in statusList" :key="key">
          <option :value="key">
            {{ status }}
          </option>
        </template>
      </select>
      <div class="invalid-feedback" v-if="errors.status_id">
        <template v-for="error in errors.status_id">
          {{ error }}
        </template>
      </div>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
  </form>
</template>

<script>
import {onMounted} from "vue";
import useProject from "../../composition/project";
import useTask from "../../composition/task";

export default {
  props: {
    task: {
      require: true,
      type: Object
    },
    errors: {
      require: true,
      type: Object
    },
    saveTask: {
      require: true,
      type: Function
    }
  },

  setup() {
    const {statusList, getStatusList} = useTask()
    const {projectList, getProjectList} = useProject()

    onMounted(() => {
      getStatusList()
      getProjectList()
    })

    return {
      projectList,
      statusList
    }
  }
}
</script>