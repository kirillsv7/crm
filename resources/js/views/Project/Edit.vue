<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Project edit</div>
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
import {onMounted} from "vue"
import useProject from "../../composition/project";
import useCrudAlert from "../../composition/crudalert";
import ProjectForm from "../../components/Project/Form";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    ProjectForm,
    CrudAlert
  },
  props: {
    id: {
      required: true,
      type: String
    },
    created: {
      required: false,
      type: Boolean,
    },
  },

  setup(props) {
    const {project, errors, getProject, updateProject} = useProject()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const saveProject = async () => {
      crudEvent.value = 'updating'
      crudEventText.value = 'Updating project...'
      alertType.value = 'info'
      await updateProject(props.id)
      if (Object.keys(errors.value).length === 0) {
        crudEvent.value = 'updated'
        crudEventText.value = 'Project updated!'
        alertType.value = null
      } else {
        crudEvent.value = 'error'
        crudEventText.value = 'Check fields!'
        alertType.value = 'danger'
      }
    }

    const toggleCreatedAlert = async () => {
      if (props.created) {
        crudEvent.value = 'created'
        crudEventText.value = 'Project created!'
      }
    }

    onMounted(() => {
      getProject(props.id)
      toggleCreatedAlert()
    })

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