<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
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
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    ProjectForm,
    CrudAlert
  },

  setup() {
    const crudEvent = ref('')
    const crudEventText = ref(null)
    const alertType = ref(null)
    const {errors, storeProject} = useProject()
    const project = ref({
      'title': '',
      'description': '',
      'deadline': '',
      'client_id': '',
      'user_id': '',
      'status_id': ''
    })

    const saveProject = async () => {
      crudEvent.value = null
      await storeProject({...project.value})
      if (Object.keys(errors.value).length !== 0) {
        crudEvent.value = 'error'
        crudEventText.value = 'Check fields!'
        alertType.value = 'danger'
      }
    }

    return {
      crudEvent,
      crudEventText,
      alertType,
      project,
      errors,
      saveProject
    }
  }
}
</script>