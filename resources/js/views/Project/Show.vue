<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-header">Project details</div>
          <div class="card-body">
            <dl>
              <dt>Title</dt>
              <dd>{{ project.title }}</dd>
              <dt>Description</dt>
              <dd>{{ project.description }}</dd>
              <dt>Deadline</dt>
              <dd>{{ project.deadline_inverted }}</dd>
              <dt>Client</dt>
              <dd>{{ project.client_company }}</dd>
              <dt>Assigned user</dt>
              <dd v-html="project.user_name"></dd>
              <dt>Status</dt>
              <dd>{{ project.status }}</dd>
            </dl>
          </div>
        </div>
        <MediaElement :media="project.media"/>
      </div>
    </div>
  </div>
  <template v-if="tasks.length">
    <div class="container-fluid mb-3">
      <div class="row">
        <div class="col-12">
          <div class="card m-0">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
              Project tasks
            </div>
            <div class="card-body">
              <TaskTable
                  :tasks="tasks"
                  :availableFilters="['status']"
              />
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
  <template v-else>
    <div class="container my-3">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card m-0">
            <div class="card-body">
              <div class="text-center">Project hasn't tasks yet</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
</template>

<script>
import {onMounted, watch} from "vue";
import {useRoute} from "vue-router";
import useProject from "../../composition/project";
import useTask from "../../composition/task";
import MediaElement from "../../components/UI/MediaElement";
import TaskTable from "../../components/Task/Table";
import PaginationElement from "../../components/UI/PaginationElement";

export default {
  components: {
    MediaElement,
    TaskTable,
    PaginationElement
  },
  props: {
    id: {
      required: true,
      type: String
    }
  },

  setup(props) {
    const route = useRoute()
    const {project, getProject} = useProject()
    const {tasks, pagination, getTasksByProject} = useTask()

    onMounted(() => {
      getProject(props.id)
      getTasksByProject(props.id)
    })

    watch(() => route.query, () => getTasksByProject(props.id))

    return {
      project,
      tasks,
      pagination
    }
  }
}
</script>