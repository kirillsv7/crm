<template>
  <CrudAlert :crudEvent="crudEvent">Project deleted!</CrudAlert>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Project list
          </div>
          <div class="card-body">
            <ProjectTable :projects="projects" :delete-project="deleteProject"/>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-center">
              <PaginationElement :pagination="pagination"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router"
import useProject from "../../composition/project";
import ProjectTable from "./ProjectTable"
import PaginationElement from "../UI/PaginationElement"
import CrudAlert from "../UI/CrudAlert";

export default {
  name: 'ProjectIndex',

  components: {
    ProjectTable,
    PaginationElement,
    CrudAlert
  },

  setup() {
    const crudEvent = ref(null)
    const route = useRoute()
    const {projects, pagination, getProjects, destroyProject} = useProject()

    const deleteProject = async (id) => {
      crudEvent.value = null
      if (!window.confirm('Are you sure you want to delete?')) return
      await destroyProject(id);
      await getProjects();
      crudEvent.value = 'deleted'
    }

    onMounted(getProjects)

    watch(
        () => route.query.page,
        getProjects
    )

    return {
      crudEvent,
      projects,
      pagination,
      deleteProject
    }
  }
}
</script>