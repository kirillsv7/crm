<template>
  <FilePond
      :label-idle="labelIdle"
      ref="filePond"
      allow-multiple="true"
      accepted-file-types="image/jpeg, image/png"
      instant-upload="false"
      max-files="10"
      imagePreviewHeight="100"
      @updatefiles="handleUpdateFiles"
  />
</template>

<script>
import {onMounted, ref, watch} from "vue";
import vueFilePond from "vue-filepond"
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type"
import FilePondPluginImagePreview from "filepond-plugin-image-preview"

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
)

export default {
  props: {
    model: {
      require: true,
      type: Object
    },
    saved: {
      require: true,
      type: Number
    }
  },
  components: {
    FilePond
  },

  setup(props) {
    const filePond = ref(null)
    const labelIdle = ref('')

    const handleUpdateFiles = (files) => {
      if (files.length) {
        props.model.files = files.map(files => files.file)
        labelIdle.value = `Drop files here - ${files.length}/${filePond.value.maxFiles} files added`
      } else {
        labelIdle.value = `Drop files here - max ${filePond.value.maxFiles} files`
      }
    }

    const removeUploadedFiles = () => {
      filePond.value.removeFiles()
      delete props.model.files
    }

    onMounted(() => labelIdle.value = `Drop files here - max ${filePond.value.maxFiles} files`)

    watch(() => props.saved, () => removeUploadedFiles())

    return {
      filePond,
      labelIdle,
      handleUpdateFiles,
    }
  }
}
</script>