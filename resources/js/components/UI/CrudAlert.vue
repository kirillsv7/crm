<template>
  <transition name="fade-vertical">
    <div class="alert-container position-relative d-flex justify-content-center" v-if="event">
      <div class="alert position-absolute shadow text-center"
           :class="[alertType ? 'alert-'+alertType : 'alert-success']"
           role="alert">
        <slot></slot>
      </div>
    </div>
  </transition>
</template>

<script>
import {onUpdated, ref} from "vue";

export default {
  name: "CrudAlert",

  props: {
    crudEvent: {
      required: false,
      type: String,
    },
    alertType: {
      required: false,
      type: String
    }
  },

  setup(props) {

    const event = ref(null)

    const processEvent = () => {
      event.value = props.crudEvent
      setTimeout(() => event.value = null, 2000)
    }

    onUpdated(processEvent)

    return {
      event
    }
  }
}
</script>

<style lang="scss" scoped>
.alert-container {
  z-index: 1;
}

.alert {
  top: 2rem;
}
</style>