<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-3">
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
import {inject} from "vue"
import useProject from "../../composition/project";
import ProjectForm from "../../components/Project/Form";

export default {
  components: {
    ProjectForm,
  },

  setup() {
    const {project, errors, storeProject} = useProject()
    const alertMessage = inject('alertMessage')
    const alertClass = inject('alertClass')

    const saveProject = async () => {
      alertMessage.value = 'Creating project...'
      alertClass.value = 'info'
      try {
        await storeProject(project.value)
      } catch (e) {
        alertMessage.value = e.message
        alertClass.value = 'danger'
      }
    }

    return {
      project,
      errors,
      saveProject
    }
  }
}
</script>