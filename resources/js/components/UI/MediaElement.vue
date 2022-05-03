<template>
  <div class="card">
    <div class="card-header">{{ title }}</div>
    <div class="card-body">
      <div class="container">
        <div class="row">
          <template v-for="file in media" :key="file.id">
            <div class="col-6 col-md-4 col-lg-3 pb-4">
              <img class="img-fluid" :src="file.thumb">
              <div class="d-flex mt-1">
                <small class="mr-2 text-break">{{ file.name }}</small>
                <template v-if="this.$route.name.includes('edit')">
                  <button class="btn btn-light btn-sm d-block ml-auto" type="button" @click="deleteMedia(file.id)">
                    <i class="cil-trash"></i>
                  </button>
                </template>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import useMedia from "../../composition/media";

export default {
  props: {
    title: {
      required: false,
      type: String,
      default: 'Media'
    },
    media: {
      required: true,
      type: Object,
      default: {}
    }
  },
  emits: [
    'mediaDeleted'
  ],

  setup(props, context) {
    const {destroyMedia} = useMedia()

    const deleteMedia = async (id) => {
      if (!window.confirm('Are you sure you want to delete?')) return
      await destroyMedia(id);
      context.emit('mediaDeleted', id)
    }

    return {
      deleteMedia
    }
  }
}
</script>