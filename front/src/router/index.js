import Vue from 'vue'
import VueRouter from 'vue-router'
//数据资源
import Home from '@views/home/Home.vue'
import ModelManage from '../views/modelmanage/ModelManage.vue'
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
    }
]
const originalPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err)
}

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router