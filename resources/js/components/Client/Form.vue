<template>
  <form id="project-form" @submit.prevent="saveClient">
    <div class="form-group">
      <label>Company</label>
      <input class="form-control" :class="{'is-invalid': errors.company}" name="company" type="text"
             v-model="client.company">
      <div class="invalid-feedback" v-if="errors.company">
        <template v-for="error in errors.company">
          {{ error }}
        </template>
      </div>
    </div>
    <div class="form-group">
      <label>VAT</label>
      <input class="form-control" :class="{'is-invalid': errors.vat}" name="vat" type="text"
             v-model="client.vat">
      <div class="invalid-feedback" v-if="errors.vat">
        <template v-for="error in errors.vat">
          {{ error }}
        </template>
      </div>
    </div>
    <div class="form-group">
      <label>Address</label>
      <input class="form-control" :class="{'is-invalid': errors.address}" name="address" type="text"
             v-model="client.address">
      <div class="invalid-feedback" v-if="errors.address">
        <template v-for="error in errors.address">
          {{ error }}
        </template>
      </div>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
  </form>
</template>

<script>
export default {
  props: {
    client: {
      require: true,
      type: Object
    },
    errors: {
      require: true,
      type: Object
    },
    saveClient: {
      require: true,
      type: Function
    }
  }
}
</script>