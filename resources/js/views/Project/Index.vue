<template>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Project list
          </div>
          <div class="card-body">
            <ProjectTable
                :projects="projects"
                :deleteProject="deleteProject"
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
import {useRoute} from "vue-router"
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
    const {projects, pagination, getProjects, destroyProject} = useProject()
    const alertMessage = inject('alertMessage')
    const alertClass = inject('alertClass')

    const deleteProject = async (id) => {
      if (!window.confirm('Are you sure you want to delete?')) return
      alertMessage.value = 'Deleting project...'
      alertClass.value = 'info'
      await destroyProject(id);
      alertMessage.value = 'Project deleted!'
      alertClass.value = 'warning'
    }

    onMounted(getProjects)

    watch(() => route.query.page, getProjects)

    return {
      projects,
      pagination,
      deleteProject
    }
  }
}
</script>