<template>
  <form id="project-form" enctype="multipart/form-data" @submit.prevent="saveProject">
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
        <template v-for="client in clientList" :key="client.id">
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
        <template v-for="user in userList" :key="user.id">
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
        <template v-for="(status, key) in statusList" :key="key">
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
    <div class="form-group">
      <label>Media upload</label>
      <FileUpload :model="project" :saved="saved"/>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
  </form>
</template>

<script>
import {onMounted} from "vue";
import FileUpload from "../UI/Form/FileUpload";
import useClient from "../../composition/client";
import useUser from "../../composition/user";
import useProject from "../../composition/project";

export default {
  props: {
    project: {
      require: true,
      type: Object
    },
    errors: {
      require: true,
      type: Object
    },
    saved:{
      require: false,
      type: Number
    },
    saveProject: {
      require: true,
      type: Function
    }
  },
  components: {
    FileUpload
  },

  setup() {
    const {statusList, getStatusList} = useProject()
    const {clientList, getClientList} = useClient()
    const {userList, getUserList} = useUser()

    onMounted(() => {
      getStatusList()
      getClientList()
      getUserList()
    })

    return {
      clientList,
      userList,
      statusList
    }
  }
}
</script>