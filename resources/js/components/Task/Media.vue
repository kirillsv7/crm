<template>
  <div class="card">
    <div class="card-header">{{ 'Task media' }}</div>
    <div class="card-body">
      <div class="container">
        <div class="row">
          <template v-for="mediaItem in media" :key="mediaItem.id">
            <div class="col-6 col-md-4 col-lg-3 pb-4">
              <img class="img-fluid" :src="mediaItem.original_url">
              <template v-if="this.$route.name == 'task.edit'">
                <button class="btn btn-link d-block mx-auto media-remove" data-id="{{ mediaItem.id }}"
                        type="button">
                  Remove file
                </button>
              </template>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    media: {
      required: true,
      type: Object
    }
  },

  setup() {
    return {}
  }
}
</script>