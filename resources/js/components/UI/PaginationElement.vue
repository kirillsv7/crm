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
              :to="convertedApiURL(link.url)"
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
import {onUpdated} from "vue";
import {useRoute, useRouter} from "vue-router";

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

    const convertedApiURL = (url) => {
      const path = route.path
      const query = Object.fromEntries((new URL(url)).searchParams.entries())
      return {path, query}
    }

    onUpdated(() => {
      // If current page exceed latest page, this hook replaces page number
      if (props.pagination.current_page > props.pagination.last_page) {
        const newUrl = convertedApiURL(props.pagination.links[props.pagination.links.length - 2].url)
        router.push(newUrl)
      }
    })

    return {
      convertedApiURL
    }
  }
}
</script>