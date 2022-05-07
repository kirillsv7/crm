require('./bootstrap');
import {createApp} from "vue";
import router from './router'
import {abilitiesPlugin} from '@casl/vue'
import {Ability} from '@casl/ability'
import AppRoot from "./views/AppRoot";

const app = createApp(AppRoot)

app
    .use(router)
    .use(abilitiesPlugin, new Ability([]))
    .mount('#app')