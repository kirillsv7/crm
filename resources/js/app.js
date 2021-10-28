require('./bootstrap');
import coreui from "@coreui/coreui"
import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

import {createApp} from "vue";
import router from './router'

const app = createApp({})

app.use(router)
    .mount('#app')