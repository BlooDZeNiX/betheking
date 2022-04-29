import { createRouter, createWebHashHistory, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Streamers from '../views/Streamers.vue'
import Voters from '../views/Voters.vue'
import Login from '../views/Login.vue'
import SignUp from "../views/SignUp.vue"
import PasswordRecovery from "../views/PasswordRecovery.vue"
import Games from "../views/Games.vue"
import Profile from "../views/Profile.vue"
import Gold from "../views/Gold.vue"
import Administration from "../src/components/Administration.vue"
import Dashboard from "../views/Dashboard.vue"
import GamesDashboard from "../views/GamesDashboard.vue"
import StreamersDashboard from '../views/StreamersDashboard.vue'
import UsersDashboard from '../views/UsersDashboard.vue'
import EditProfile from "../views/EditProfile.vue"
import ChangePassword from "../views/ChangePassword.vue"
import DefaultLayout from "../src/components/DefaultLayout.vue"
import AuthLayout from "../src/components/AuthLayout.vue"
import StreamersVoteAds from "../views/StreamersVoteAds.vue"
import GamesVoteAds from "../views/GamesVoteAds.vue"
import store from '../src/store/index'

const routes = [{
        path: "/",
        redirect: "/Home",
        name: "Home",
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            { path: '/Home', name: 'Home', component: Home },
            { path: '/Streamers', name: 'Streamers', component: Streamers },
            { path: '/Games', name: 'Games', component: Games },
            { path: '/Voters', name: 'Voters', component: Voters },
            { path: '/Profile', name: 'Profile', component: Profile },
            { path: '/Gold', name: 'Gold', component: Gold },
            { path: '/Administration', name: 'Administration', component: Administration },
            { path: '/Dashboard', name: 'Dashboard', component: Dashboard },
            { path: '/GamesDashboard', name: 'GamesDashboard', component: GamesDashboard },
            { path: '/UsersDashboard', name: 'UsersDashboard', component: UsersDashboard },
            { path: '/StreamersDashboard', name: 'StreamersDashboard', component: StreamersDashboard },
            { path: '/Profile/Edit', name: 'EditProfile', component: EditProfile, props: true },
            { path: '/Profile/Edit/Password', name: 'ChangePassword', component: ChangePassword, props: true },
            { path: '/StreamersVoteAds', name: 'StreamersVoteAds', component: StreamersVoteAds, props: true },
            { path: '/GamesVoteAds', name: 'GamesVoteAds', component: GamesVoteAds, props: true },
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
            }, {
                path: "/passwordRecovery",
                name: "PasswordRecovery",
                component: PasswordRecovery,
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
        next({ name: 'Home' });
    } else {
        next();
    }
})

export default router;