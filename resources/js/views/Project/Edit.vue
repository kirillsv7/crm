<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
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
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    ProjectForm,
    AlertElement
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
    const alertMessage = ref('')
    const alertClass = ref('')

    const saveProject = async () => {
      alertMessage.value = 'Updating project...'
      alertClass.value = 'info'
      await updateProject(props.id)
      if (Object.keys(errors.value).length === 0) {
        alertMessage.value = 'Project updated!'
        alertClass.value = null
      } else {
        alertMessage.value = 'Check fields!'
        alertClass.value = 'danger'
      }
    }

    const toggleCreatedAlert = async () => {
      if (props.created) {
        alertMessage.value = 'Project created!'
      }
    }

    onMounted(() => {
      getProject(props.id)
      toggleCreatedAlert()
    })

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