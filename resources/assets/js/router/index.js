import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";
import Login from "../pages/Login.vue"

Vue.use(VueRouter)

const routes = [
    {
        path: "/login",
        component: Login,
        name: "Login"
    },
    {
        path: "/",
        redirect: "/login"
    }
]

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
})

export default router