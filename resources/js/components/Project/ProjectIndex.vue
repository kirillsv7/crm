<template>
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
import {onMounted, watch} from "vue";
import {useRoute} from "vue-router"
import useProject from "../../composition/project";
import ProjectTable from "./ProjectTable"
import PaginationElement from "../UI/PaginationElement"

export default {
  name: 'ProjectIndex',

  components: {
    ProjectTable,
    PaginationElement
  },

  setup() {
    const route = useRoute()
    const {projects, pagination, getProjects, destroyProject} = useProject()

    const deleteProject = async (id) => {
      if (!window.confirm('Are you sure you want to delete?')) {
        return
      }

      await destroyProject(id);
      await getProjects();
    }

    onMounted(getProjects)

    watch(
        () => route.query.page,
        getProjects
    )

    return {
      projects,
      pagination,
      deleteProject
    }
  }
}
</script>