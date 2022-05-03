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
                :saved="saved"
                :saveProject="saveProject"
            />
          </div>
        </div>
        <MediaElement :media="project.media" @mediaDeleted="getProject(id)"/>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted, ref} from "vue"
import useProject from "../../composition/project";
import AlertElement from "../../components/UI/AlertElement";
import ProjectForm from "../../components/Project/Form";
import MediaElement from "../../components/UI/MediaElement";

export default {
  components: {
    ProjectForm,
    AlertElement,
    MediaElement
  },
  props: {
    id: {
      required: true,
      type: String
    },
    created: {
      required: false,
      type: Boolean,
      default: false
    },
  },

  setup(props) {
    const {project, errors, getProject, updateProject} = useProject()
    const alertMessage = ref('')
    const alertClass = ref('')
    const saved = ref(null)

    const saveProject = async () => {
      alertMessage.value = 'Updating project...'
      alertClass.value = 'info'
      try {
        await updateProject(props.id)
        saved.value = Date.now()
        alertMessage.value = 'Project updated!'
        alertClass.value = null
      } catch (e) {
        alertMessage.value = e.message
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
      saved,
      getProject,
      saveProject
    }
  }
}
</script>