import { createApp } from 'vue'
import App from './App.vue'
import store from './store'
import router from "../router";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';

library.add(fas);


import "./index.css";

createApp(App).use(store).use(router).component('fa', FontAwesomeIcon).mount('#app')
