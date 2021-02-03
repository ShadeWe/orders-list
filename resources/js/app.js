require('./bootstrap');

import { createApp } from 'vue';
import { createWebHistory, createRouter } from 'vue-router';
import routes from "./routes";
import Index from './components/Index.vue';

const app = createApp({
    components: {
        "Index": Index
    },
});

const router = createRouter({
    history: createWebHistory(),
    routes
});


app.use(router);
app.mount("#app");
