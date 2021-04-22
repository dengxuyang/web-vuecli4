//请求接口封装
import axios from 'axios'
export function request(config) {
    const instance = axios.create({
            baseURL: process.env.VUE_APP_BASE_URL,
            timeout: 5000
        })
        //请求拦截
    instance.interceptors.request.use(config => {
            // if (config.url !== '/token') {
            //     const token = store.state.token
            //     config.params.access_token = token
            //     config.params.datajson = { destination_id: 531 }
            // }
            return config
        }, error => {})
        //响应拦截
    instance.interceptors.response.use(res => {
        // console.log(res);
        return res.data
    }, err => {
        // console.log(err);
    })
    return instance(config)

    // .then(res => {
    //     resolve(res)
    // }).catch(err => {
    //     reject(err)
    // })
}