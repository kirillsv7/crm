<template>
  <FilePond
      label-idle="Drop files here..."
      ref="filePond"
      allow-multiple="true"
      accepted-file-types="image/jpeg, image/png"
      instant-upload="false"
      imagePreviewHeight="100"
      @updatefiles="handleUpdateFiles"
  />
</template>

<script>
import {ref, watch} from "vue";
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

    const handleUpdateFiles = (files) => {
      if (files.length)
        props.model.files = files.map(files => files.file)
    }

    const removeUploadedFiles = () => {
      filePond.value.removeFiles()
      delete props.model.files
    }

    watch(() => props.saved, () => removeUploadedFiles())

    return {
      filePond,
      handleUpdateFiles,
    }
  }
}
</script>