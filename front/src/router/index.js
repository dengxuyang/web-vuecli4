import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
//数据资源
import Home from '@views/home/Home.vue'
import ModelManage from '@views/modelmanage/ModelManage.vue'
import Login from '@/login/login.vue'
Vue.use(VueRouter)

const routes = [{
        path: '/',
        name: 'Home',
        redirect: { name: 'home' },
    },
    {
        path: '/home',
        name: 'home',
        component: Home,
    }, {
        path: '/modelmanage',
        name: 'modelmanage',
        component: ModelManage,
    },
    {
        path: '/loginpage',
        name: 'loginpage',
        // redirect: { name: 'basedata' },
        component: Login,
    }
]
//解决vuecli路由报错
const originalPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err)
}

const router = new VueRouter({
    mode: 'hash',
    base: process.env.BASE_URL,
    routes
})
router.beforeEach((to, from, next) => {
    if (to.name !== 'loginpage' && !store.state.login_status) next({ name: 'loginpage' })
    else next()
})

export default router