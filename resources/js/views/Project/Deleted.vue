<template>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Project deleted
          </div>
          <div class="card-body">
            <ProjectTable
                :projects="projects"
                :recoverProject="recoverProject"
            />
          </div>
          <div class="card-footer d-flex justify-content-center">
            <PaginationElement :pagination="pagination"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {inject, onMounted, watch} from "vue";
import {useRoute} from "vue-router";
import useProject from "../../composition/project";
import ProjectTable from "../../components/Project/Table";
import PaginationElement from "../../components/UI/PaginationElement";

export default {
  components: {
    ProjectTable,
    PaginationElement,
  },

  setup() {
    const route = useRoute()
    const {projects, pagination, getProjectsDeleted, restoreProject} = useProject()
    const alertMessage = inject('alertMessage')
    const alertClass = inject('alertClass')

    const recoverProject = async (id) => {
      if (!window.confirm('Are you sure you want to restore?')) return
      alertMessage.value = 'Restoring project...'
      alertClass.value = 'info'
      await restoreProject(id);
      alertMessage.value = 'Project restored!'
      alertClass.value = 'warning'
    }

    onMounted(getProjectsDeleted)

    watch(() => route.query.page, getProjectsDeleted)

    return {
      projects,
      pagination,
      recoverProject
    }
  }
}
</script>