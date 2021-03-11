import Vue from 'vue'
import VueRouter from 'vue-router'
//数据资源
import Home from '@views/dataresource/Home.vue'
import BaseData from '@views/dataresource/basedata/BaseData.vue'
import RealTimeData from '@views/dataresource/realtimedata/RealTimeData.vue'
import StaistcsData from '@views/dataresource/statisticsdata/StaistcsData.vue'
import ReportData from '@views/dataresource/reportdata/ReportData.vue'


Vue.use(VueRouter)

const routes = [{

        path: '/',
        name: 'Home',
        redirect: { name: 'basedata' },
        component: Home,
        children: [{
            path: '/basedata',
            name: 'basedata',
            component: BaseData,
        }, {
            path: '/realtimedata',
            name: 'realtimedata',
            component: RealTimeData,
        }, {
            path: '/statisticsdata',
            name: 'statisticsdata',
            component: StaistcsData,
        }, {
            path: '/reportdata',
            name: 'reportdata',
            component: ReportData,
        }]
    },

]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router