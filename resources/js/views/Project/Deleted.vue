<template>
  <AlertElement :alertMessage="alertMessage" :alertClass="alertClass"/>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Project deleted
          </div>
          <div class="card-body">
            <ProjectTable :projects="projectsDeleted" :recoverProject="recoverProject"/>
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
import {onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router";
import useProject from "../../composition/project";
import ProjectTable from "../../components/Project/Table";
import PaginationElement from "../../components/UI/PaginationElement";
import AlertElement from "../../components/UI/AlertElement";

export default {
  components: {
    ProjectTable,
    PaginationElement,
    AlertElement
  },

  setup() {
    const route = useRoute()
    const {projectsDeleted, pagination, getProjectsDeleted, restoreProject} = useProject()
    const alertMessage = ref('')
    const alertClass = ref('')

    const recoverProject = async (id) => {
      if (!window.confirm('Are you sure you want to restore?')) return
      await restoreProject(id);
      await getProjectsDeleted();
      alertMessage.value = 'Project restored!'
      alertClass.value = 'warning'
    }

    onMounted(getProjectsDeleted)

    watch(
        () => route.query.page,
        getProjectsDeleted
    )

    return {
      alertMessage,
      alertClass,
      projectsDeleted,
      pagination,
      recoverProject
    }
  }
}
</script>