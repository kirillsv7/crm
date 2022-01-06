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
import {onMounted, ref} from "vue"
import useProject from "../../composition/project";
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
    const crudEvent = ref('')
    const crudEventText = ref(null)
    const alertType = ref(null)
    const {project, errors, getProject, updateProject} = useProject()

    const saveProject = async () => {
      crudEvent.value = null
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

    onMounted(() => {getProject(props.id), toggleCreatedAlert()})

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