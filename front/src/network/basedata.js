import { request } from '@network/request';
const dataApi = '/back/gthmmc/gthmmc/index.php?m=amobiletour&c=dataMange&a='
    /**
     * 获取资源字段方法
     * @param {*} params 
     * @returns 
     */
export function getResourcefield(params) {
    return request({
        method: 'get',
        url: dataApi + 'getResourcefield',
        params
    })
}
/**
 * 获取资源字段方法
 * @param {*} params 
 * @returns 
 */
export function queryDataOfResource(params) {
    return request({
        method: 'get',
        url: dataApi + 'queryDataOfResource',
        params
    })
}
/**
 * 新增资源字段方法
 * @param {*} params 
 * @returns 
 */
export function addDataOfResource(params) {
    return request({
        method: 'post',
        url: dataApi + 'addDataOfResource',
        // headers: {'Content-Type': 'application/json'},
        data: params
    })
}
/**
 * 修改资源字段方法
 * @param {*} params 
 * @returns 
 */
 export function modifyDataOfResource(params) {
    return request({
        method: 'post',
        url: dataApi + 'modifyDataOfResource',
        // headers: {'Content-Type': 'application/json'},
        data: params
    })
}
/**
 * 删除资源方法
 * @param {*} params 
 * @returns 
 */
 export function deleteDataOfResource(params) {
    return request({
        method: 'get',
        url: dataApi + 'deleteDataOfResource',
        // headers: {'Content-Type': 'application/json'},
        params
    })
}
/**
 * 批量删除资源方法
 * @param {*} params 
 * @returns 
 */
 export function deleteBatchData(params) {
    return request({
        method: 'get',
        url: dataApi + 'deleteBatchData',
        // headers: {'Content-Type': 'application/json'},
        params
    })
}

/**
 *导出
 *
 * @export
 * @param {*} params
 * @return {*} 
 */
export function outputplanmodel(params) {
    return request({
        method: 'get',
        url: dataApi + 'outputplanmodel',
        // headers: {'Content-Type': 'application/json'},
        params,
        responseType: 'arraybuffer'
      
    })
}