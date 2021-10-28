<template>
  <div class="container my-3">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Project create</div>
          <div class="card-body">
            <form id="project-form" @submit.prevent="saveProject">
              <div class="form-group">
                <label>Title</label>
                <input class="form-control" :class="{'is-invalid': errors.title}" name="title" type="text"
                       v-model="project.title">
                <div class="invalid-feedback" v-if="errors.title">
                  <template v-for="error in errors.title">
                    {{ error }}
                  </template>
                </div>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" :class="{'is-invalid': errors.description}" name="description"
                          v-model="project.description"></textarea>
                <div class="invalid-feedback" v-if="errors.description">
                  <template v-for="error in errors.description">
                    {{ error }}
                  </template>
                </div>
              </div>
              <div class="form-group">
                <label>Deadline</label>
                <input class="form-control" :class="{'is-invalid': errors.deadline}" name=" deadline" type="date"
                       v-model="project.deadline">
                <div class="invalid-feedback" v-if="errors.deadline">
                  <template v-for="error in errors.deadline">
                    {{ error }}
                  </template>
                </div>
              </div>
              <div class="form-group">
                <label>Client</label>
                <select class="form-control" :class="{'is-invalid': errors.client_id}" name="client_id"
                        v-model="project.client_id">
                  <option value="">Select client</option>
                  <template v-for="client in clients" :key="client.id">
                    <option :value="client.id">
                      {{ client.company }}
                    </option>
                  </template>
                </select>
                <div class="invalid-feedback" v-if="errors.client_id">
                  <template v-for="error in errors.client_id">
                    {{ error }}
                  </template>
                </div>
              </div>
              <div class="form-group">
                <label>Assigned user</label>
                <select class="form-control" :class="{'is-invalid': errors.user_id}" name="user_id"
                        v-model="project.user_id">
                  <option value="">Select user</option>
                  <template v-for="user in users" :key="user.id">
                    <option :value="user.id">
                      {{ user.name }}
                    </option>
                  </template>
                </select>
                <div class="invalid-feedback" v-if="errors.user_id">
                  <template v-for="error in errors.user_id">
                    {{ error }}
                  </template>
                </div>
              </div>
              <div class="form-group">
                <label>Status</label>
                <select class="form-control" :class="{'is-invalid': errors.status_id}" name="status_id"
                        v-model="project.status_id">
                  <option value="">Select status</option>
                  <template v-for="(status, key) in statuses" :key="key">
                    <option :value="key">
                      {{ status }}
                    </option>
                  </template>
                </select>
                <div class="invalid-feedback" v-if="errors.status_id">
                  <template v-for="error in errors.status_id">
                    {{ error }}
                  </template>
                </div>
              </div>
              <button class="btn btn-primary" type="submit">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {reactive, onMounted} from "vue"
import useProject from "../../composition/project";
import useClient from "../../composition/client";
import useUser from "../../composition/user";

export default {
  name: 'ProjectCreate',

  setup() {

    const {statuses, errors, storeProject, getStatuses} = useProject()
    const {clients, getClients} = useClient()
    const {users, getUsers} = useUser()

    const project = reactive({
      'title': '',
      'description': '',
      'deadline': '',
      'client_id': '',
      'user_id': '',
      'status_id': ''
    })

    const saveProject = async () => {
      await storeProject({...project})
    }

    onMounted([getStatuses, getClients, getUsers])

    return {
      project,
      statuses,
      clients,
      users,
      errors,
      saveProject
    }
  }
}
</script>