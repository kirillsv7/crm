<template>
  <form id="project-form" @submit.prevent="saveUser">
    <div class="form-group">
      <label>Name</label>
      <input class="form-control" :class="{'is-invalid': errors.name}" name="name" type="text"
             v-model="user.name">
      <div class="invalid-feedback" v-if="errors.name">
        <template v-for="error in errors.name">
          {{ error }}
        </template>
      </div>
    </div>
    <div class="form-group">
      <label>Email</label>
      <input class="form-control" :class="{'is-invalid': errors.email}" name="email" type="email"
             v-model="user.email">
      <div class="invalid-feedback" v-if="errors.email">
        <template v-for="error in errors.email">
          {{ error }}
        </template>
      </div>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input class="form-control" :class="{'is-invalid': errors.password}" name="password" type="password"
             v-model="user.password">
      <div class="invalid-feedback" v-if="errors.password">
        <template v-for="error in errors.password">
          {{ error }}
        </template>
      </div>
    </div>
    <div class="form-group">
      <label>Password confirmation</label>
      <input class="form-control" :class="{'is-invalid': errors.password_confirmation}" name="password_confirmation"
             type="password"
             v-model="user.password_confirmation">
      <div class="invalid-feedback" v-if="errors.password_confirmation">
        <template v-for="error in errors.password_confirmation">
          {{ error }}
        </template>
      </div>
    </div>
    <template v-if="'is_admin' in user">
      <div class="custom-control custom-switch mb-3">
        <input id="is_admin" class="custom-control-input" name="is_admin" type="checkbox"
               v-model="user.is_admin">
        <label class="custom-control-label" for="is_admin">Is admin</label>
      </div>
    </template>
    <button class="btn btn-primary" type="submit">Save</button>
  </form>
</template>

<script>
export default {
  props: {
    user: {
      require: true,
      type: Object
    },
    errors: {
      require: true,
      type: Object
    },
    saveUser: {
      require: true,
      type: Function
    }
  }
}
</script>