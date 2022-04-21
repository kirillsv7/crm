<template>
  <div class="card">
    <div class="card-header d-flex flex-wrap align-items-center">
      Response by:&nbsp;<span v-html="response.user"></span>&nbsp;|
      at: {{ response.created_at }}

      <router-link :to="{hash: '#response-' + response.id}" class="btn btn-link btn-sm ml-auto text-muted"
                   :id="'response-'+response.id">#{{ response.id }}
      </router-link>
      |
      <button class="btn btn-link btn-sm" type="submit"
              onclick="return confirm('Are you sure you want to delete?');">
        <i class="cil-trash"></i>
      </button>
    </div>
    <div class="card-body">
      {{ response.content }}
      <!--
            @if(response.getMedia()->count())
            <div class="row mt-3">
              @foreach(response.getMedia() as $media)
              <div class="col-6 col-md-4 col-lg-3 pb-4">
                <img class="img-fluid" src="{{ $media->getUrl() }}">
                @if(request()->routeIs('task.edit'))
                @can('manageMedia', $task)
                <button
                    class="btn btn-link d-block mx-auto media-remove"
                    data-id="{{ $media->id }}"
                    type="button">
                  Remove file
                </button>
                @endcan
                @endif
              </div>
              @endforeach
            </div>
            @endif
      -->
    </div>
  </div>
</template>

<script>
export default {
  props: {
    response: {
      required: true,
      type: Object,
    }
  },

  setup() {
    return {}
  }
}
</script>