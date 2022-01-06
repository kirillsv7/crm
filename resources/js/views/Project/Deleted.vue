<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
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
import {onMounted, watch} from "vue";
import {useRoute} from "vue-router";
import useProject from "../../composition/project";
import useCrudAlert from "../../composition/crudalert";
import ProjectTable from "../../components/Project/Table";
import PaginationElement from "../../components/UI/PaginationElement";
import CrudAlert from "../../components/UI/CrudAlert";

export default {
  components: {
    ProjectTable,
    PaginationElement,
    CrudAlert
  },

  setup() {
    const route = useRoute()
    const {projectsDeleted, pagination, getProjectsDeleted, restoreProject} = useProject()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const recoverProject = async (id) => {
      crudEvent.value = null
      if (!window.confirm('Are you sure you want to restore?')) return
      await restoreProject(id);
      await getProjectsDeleted();
      crudEvent.value = 'restored'
      crudEventText.value = 'Project restored!'
      alertType.value = 'warning'
    }

    onMounted(getProjectsDeleted)

    watch(
        () => route.query.page,
        getProjectsDeleted
    )

    return {
      crudEvent,
      crudEventText,
      alertType,
      projectsDeleted,
      pagination,
      recoverProject
    }
  }
}
</script>