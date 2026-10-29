import {createRouter, createWebHistory} from 'vue-router';
import QuotesApp from "./components/QuotesApp.vue";
import SearchQuote from "./components/SearchQuote.vue";
import CreateQuote from "./components/CreateQuote.vue";
import EditQuote from "./components/EditQuote.vue";


const routes = [
    {
      path:'/',
      name:'home',
        component:QuotesApp
    },
    {
        path:'/search',
        name:'search',
        component: SearchQuote

    },
    {
        path:'/create',
        name:'create',
        component: CreateQuote
    },
    {
        path:'/edit/:id',
        name:'edit',
        component: EditQuote
    },
];

const router = createRouter({
    history:createWebHistory(),
    routes
})

export default router;



