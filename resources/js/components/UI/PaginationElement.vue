<template>
  <nav v-if="pagination.last_page != 1">
    <ul class="pagination">
      <template v-for="(link, index) in pagination.links" :key="index">
        <li
            class="page-item"
            :class="{'active': link.active, 'disabled': !link.url}"
            :aria-current="link.active ? 'page' : ''">
          <router-link
              class="page-link"
              v-if="link.url && !link.active"
              :to="transformApiUrl(link.url)"
              v-html="link.label"
              :aria-current="link.active ? 'page' : ''"
          />
          <span class="page-link" v-else-if="link.active" v-html="link.label"></span>
          <span class="page-link" aria-hidden="true" v-else v-html="link.label"></span>
        </li>
      </template>
    </ul>
  </nav>
</template>

<script>
import {useRoute, useRouter} from "vue-router";
import {onUpdated} from "vue";

export default {
  props: {
    pagination: {
      required: true,
      type: Object,
    },
  },

  setup(props) {
    const route = useRoute()
    const router = useRouter()

    onUpdated(() => {
      if (props.pagination.current_page > props.pagination.last_page) {
        const newUrl = transformApiUrl(props.pagination.links[0].url)
        newUrl.query.page = props.pagination.last_page
        router.push(newUrl)
      }
    })

    const transformApiUrl = (link) => {
      const url = new URL(link)
      const params = new URLSearchParams(url.search)
      const newParams = {}

      params.forEach(function (value, key) {
        newParams[key] = value
      })

      return {
        path: route.path,
        query: newParams
      }
    }

    return {
      transformApiUrl
    }
  }
}
</script>