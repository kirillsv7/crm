<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Project create</div>
          <div class="card-body">
            <ProjectForm
                :project="project"
                :errors="errors"
                :saveProject="saveProject"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {reactive} from "vue"
import useProject from "../../composition/project";
import ProjectForm from "./ProjectForm";

export default {
  name: 'ProjectCreate',
  components: {
    ProjectForm
  },

  setup() {
    const {errors, storeProject} = useProject()
    const project = reactive({
      'title': '',
      'description': '',
      'deadline': '',
      'client_id': '',
      'user_id': '',
      'status_id': ''
    })

    const saveProject = async () => {
      await storeProject({...project})
    }

    return {
      project,
      errors,
      saveProject
    }
  }
}
</script>