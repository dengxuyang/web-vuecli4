import Vue from 'vue'
import App from './App.vue'
import router from './router'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import './assets/css/element.css';
import './assets/css/element-variables.scss'
import * as echarts from 'echarts';
import Fragment from 'vue-fragment'
import store from './store'
Vue.prototype.$echarts = echarts
Vue.config.productionTip = false
    //事件总线
Vue.prototype.$bus = new Vue()
Vue.use(ElementUI);
Vue.use(Fragment.Plugin)
new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')