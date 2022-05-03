<template>
  <div class="card">
    <div class="card-header d-flex flex-wrap align-items-center">
      Response by:&nbsp;<span v-html="response.user_name"></span>&nbsp;|
      at: {{ response.created_at }}

      <router-link :to="{hash: '#response-' + response.id}" class="btn btn-link btn-sm ml-auto text-muted"
                   :id="'response-'+response.id">#{{ response.id }}
      </router-link>
      |
      <button class="btn btn-link btn-sm" type="submit" onclick="return confirm('Are you sure you want to delete?');">
        <i class="cil-trash"></i>
      </button>
    </div>
    <div class="card-body">
      {{ response.content }}

      <template v-if="response.media.length">
        <div class="row mt-3">
          <div class="col-6 col-md-4 col-lg-3 pb-4" v-for="file in response.media" :key="file.id">
            <img class="img-fluid" :src="file.thumb">
            <div class="d-flex mt-1">
              <small class="mr-2 text-break">{{ file.name }}</small>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import MediaElement from "../UI/MediaElement";

export default {
  components: {
    MediaElement
  },
  props: {
    response: {
      required: true,
      type: Object,
    }
  }
}
</script>