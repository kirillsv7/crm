<template>
  <div class="position-relative d-flex justify-content-center">
    <transition name="fade-vertical">
      <div class="alert alert-success position-absolute shadow text-center"
           style="top: 2rem; z-index: 1;"
           role="alert"
           v-if="restored">
        Project restored!
      </div>
    </transition>
  </div>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Project deleted
          </div>
          <div class="card-body">
            <ProjectTable :projects="projectsDeleted" :recover-project="recoverProject"/>
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
import {useRoute} from "vue-router";
import useProject from "../../composition/project";
import ProjectTable from "./ProjectTable"
import PaginationElement from "../UI/PaginationElement"

export default {
  name: 'ProjectDeleted',

  components: {
    ProjectTable,
    PaginationElement
  },

  setup() {
    const restored = ref(false)
    const route = useRoute()
    const {projectsDeleted, pagination, getProjectsDeleted, restoreProject} = useProject()

    const recoverProject = async (id) => {
      if (!window.confirm('Are you sure you want to restore?')) {
        return
      }

      await restoreProject(id);
      await getProjectsDeleted();

      restored.value = true
      await new Promise(resolve => setTimeout(resolve, 2000))
      restored.value = false
    }

    onMounted(getProjectsDeleted)

    watch(
        () => route.query.page,
        getProjectsDeleted
    )

    return {
      restored,
      projectsDeleted,
      pagination,
      recoverProject
    }
  }
}
</script>