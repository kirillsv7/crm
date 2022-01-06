require('./bootstrap');
import coreui from "@coreui/coreui"
import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

import {createApp} from "vue";
import router from './router'
import AppRoot from "./views/AppRoot";
const app = createApp(AppRoot)

app.use(router).mount('#app')