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
              :to="link.url"
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
export default {
  props: {
    pagination: {
      required: true,
      type: Object,
    },
  }
}
</script>