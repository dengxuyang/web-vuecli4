import { request } from '@network/request';
const userApi = '/winyeahsdataback_php/gthmmc/index.php?m=winyeahsdata&c=index&a='
const dataApi = '/winyeahsdataback_php/gthmmc/index.php?m=winyeahsdata&c=dataapi&a='
export function getData(params) {
    return request({
        method: 'POST',
        url: '/cgi-bin/token',
        params
    })
}
//获取登录信息
export function oauthGetCurrentUser(params) {
    return request({
        method: 'get',
        url: userApi + 'oauthGetCurrentUser',
        params
    })
}
//获取权限信息
export function getDataApiPower(params) {
    return request({
        method: 'get',
        url: dataApi + 'getdataapipower',
        params
    })
}