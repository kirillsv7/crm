import {ref} from "vue";

export default function useCrudAlert() {

    const crudEvent = ref(null)
    const crudEventText = ref(null)
    const alertType = ref(null)

    return {
        crudEvent,
        crudEventText,
        alertType
    }
}