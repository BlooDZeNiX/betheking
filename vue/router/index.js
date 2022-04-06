import { createRouter, createWebHashHistory, createWebHistory } from 'vue-router'
import Streamers from '../views/Streamers.vue'
import Login from '../views/Login.vue'
import SignUp from "../views/SignUp.vue"
import Games from "../views/Games.vue"
import Profile from "../views/Profile.vue"
import DefaultLayout from "../src/components/DefaultLayout.vue"
import AuthLayout from "../src/components/AuthLayout.vue"
import StreamersVoteAds from "../views/StreamersVoteAds.vue"
import store from '../src/store/index'

const routes = [{
        path: "/",
        redirect: "/Streamers",
        name: "Streamers",
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            { path: '/Streamers', name: 'Streamers', component: Streamers },
            { path: '/Games', name: 'Games', component: Games },
            { path: '/Profile', name: 'Profile', component: Profile },
            { path: '/StreamersVoteAds', name: 'StreamersVoteAds', component: StreamersVoteAds, props: true },
        ]
    },
    {
        path: '/auth',
        redirect: '/login',
        name: 'Auth',
        component: AuthLayout,
        children: [{
                path: "/login",
                name: "Login",
                component: Login,
            },
            {
                path: "/signup",
                name: "SignUp",
                component: SignUp,
            },
        ]
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: 'Login' })
    } else if (store.state.user.token && (to.name === 'Login' || to.name === 'SignUp')) {
        next({ name: 'Streamers' });
    } else {
        next();
    }
})

export default router;