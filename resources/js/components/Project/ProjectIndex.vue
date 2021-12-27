<template>
  <div class="position-relative">
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
    <div class="alert alert-success position-absolute shadow text-center"
         style="top: 2rem; left: 50%; transform: translateX(-50%)"
         role="alert"
         v-if="deleted"
    >
      Project deleted!
    </div>
  </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
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
    const deleted = ref(false)
    const route = useRoute()
    const {projects, pagination, getProjects, destroyProject} = useProject()

    const deleteProject = async (id) => {
      if (!window.confirm('Are you sure you want to delete?')) {
        return
      }

      await destroyProject(id);
      await getProjects();

      deleted.value = true
      await new Promise(resolve => setTimeout(resolve, 2000))
      deleted.value = false
    }

    onMounted(getProjects)

    watch(
        () => route.query.page,
        getProjects
    )

    return {
      deleted,
      projects,
      pagination,
      deleteProject
    }
  }
}
</script>