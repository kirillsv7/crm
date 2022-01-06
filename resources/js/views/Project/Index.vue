<template>
  <CrudAlert :crudEvent="crudEvent" :alertType="alertType">{{ crudEventText }}</CrudAlert>
  <div class="container-fluid my-3">
    <div class="row">
      <div class="col-12">
        <div class="card m-0">
          <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
            Project list
          </div>
          <div class="card-body">
            <ProjectTable :projects="projects" :deleteProject="deleteProject"/>
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
import {useRoute} from "vue-router"
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
    const {projects, pagination, getProjects, destroyProject} = useProject()
    const {crudEvent, crudEventText, alertType} = useCrudAlert()

    const deleteProject = async (id) => {
      crudEvent.value = null
      if (!window.confirm('Are you sure you want to delete?')) return
      await destroyProject(id);
      await getProjects();
      crudEvent.value = 'deleted'
      crudEventText.value = 'Project deleted!'
      alertType.value = 'warning'
    }

    onMounted(getProjects)

    watch(
        () => route.query.page,
        getProjects
    )

    return {
      crudEvent,
      crudEventText,
      alertType,
      projects,
      pagination,
      deleteProject
    }
  }
}
</script>