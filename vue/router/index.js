import { createRouter, createWebHashHistory, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import SignUp from "../views/SignUp.vue"
import PasswordRecovery from "../views/PasswordRecovery.vue"
import Home from '../views/Home.vue'
import Streamers from '../views/Streamers.vue'
import Games from "../views/Games.vue"
import Profile from "../views/Profile.vue"
import EditProfile from "../views/EditProfile.vue"
import ChangePassword from "../views/ChangePassword.vue"
import Gold from "../views/Gold.vue"
import Dashboard from "../views/Dashboard.vue"
import GamesDashboard from "../views/GamesDashboard.vue"
import StreamersDashboard from '../views/StreamersDashboard.vue'
import UsersDashboard from '../views/UsersDashboard.vue'
import DefaultLayout from "../src/components/DefaultLayout.vue"
import AuthLayout from "../src/components/AuthLayout.vue"
import StreamersVoteAds from "../views/StreamersVoteAds.vue"
import GamesVoteAds from "../views/GamesVoteAds.vue"
import AboutUs from "../views/AboutUs.vue"
import ContactUs from "../views/ContactUs.vue"
import Help from "../views/Help.vue"
import PrivacyPolicy from "../views/PrivacyPolicy.vue"
import store from '../src/store/index'

const routes = [{
        path: "/",
        redirect: "/home",
        name: "Home",
        component: DefaultLayout,
        meta: { requiresAuth: true },
        props: true,
        children: [
            { path: '/home', name: 'Home', component: Home, props: true },
            { path: '/streamers', name: 'Streamers', component: Streamers },
            { path: '/games', name: 'Games', component: Games },
            { path: '/profile', name: 'Profile', component: Profile },
            { path: '/gold', name: 'Gold', component: Gold },
            { path: '/dashboard', name: 'Dashboard', component: Dashboard, props: true },
            { path: '/games-dashboard', name: 'GamesDashboard', component: GamesDashboard, props: true },
            { path: '/users-dashboard', name: 'UsersDashboard', component: UsersDashboard, props: true },
            { path: '/streamers-dashboard', name: 'StreamersDashboard', component: StreamersDashboard, props: true },
            { path: '/profile/edit', name: 'EditProfile', component: EditProfile, props: true },
            { path: '/profile/edit/password', name: 'ChangePassword', component: ChangePassword, props: true },
            { path: '/streamers-vote-ads', name: 'StreamersVoteAds', component: StreamersVoteAds, props: true },
            { path: '/games-vote-ads', name: 'GamesVoteAds', component: GamesVoteAds, props: true },
            { path: '/about-us', name: 'AboutUs', component: AboutUs },
            { path: '/help', name: 'Help', component: Help },
            { path: '/privacy-policy', name: 'PrivacyPolicy', component: PrivacyPolicy },
            { path: '/contact-us', name: 'ContactUs', component: ContactUs },
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
                path: "/password-recovery",
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