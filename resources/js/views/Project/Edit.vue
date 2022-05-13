<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-3">
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
import {inject, onMounted, ref} from "vue"
import useProject from "../../composition/project";
import ProjectForm from "../../components/Project/Form";
import MediaElement from "../../components/UI/MediaElement";

export default {
  components: {
    ProjectForm,
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
    const alertMessage = inject('alertMessage')
    const alertClass = inject('alertClass')
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
      project,
      errors,
      saved,
      getProject,
      saveProject
    }
  }
}
</script>