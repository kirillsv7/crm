<template>
  <transition name="fade-vertical">
    <div class="alert-container position-relative d-flex justify-content-center" v-if="message">
      <div class="alert position-absolute shadow text-center"
           :class="[alertClass ? 'alert-'+alertClass : 'alert-success']"
           role="alert">
        {{ message }}
      </div>
    </div>
  </transition>
</template>

<script>
import {onUpdated, ref} from "vue";

export default {
  props: {
    alertMessage: {
      required: true,
      type: String,
    },
    alertClass: {
      required: false,
      type: String
    },
    alertTimeout: {
      required: false,
      type: Number
    }
  },

  setup(props) {
    const message = ref(null)
    const processEvent = () => {
      message.value = props.alertMessage
      setTimeout(() => message.value = null, props.alertTimeout ?? 2000)
    }

    onUpdated(processEvent)

    return {message}
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