<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
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
import {ref} from "vue"
import useProject from "../../composition/project";
import ProjectForm from "../../components/Project/Form";
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    ProjectForm,
    AlertElement
  },

  setup() {
    const {project, errors, storeProject} = useProject()
    const alertMessage = ref('')
    const alertClass = ref('')

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
      alertMessage,
      alertClass,
      project,
      errors,
      saveProject
    }
  }
}
</script>