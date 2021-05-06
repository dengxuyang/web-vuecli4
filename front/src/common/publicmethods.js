//时间格式化
/**
 *
 *
 * @export 时间格式化
 * @param {*} dateStr 时间戳或者时间字符串
 * @param {string} [fmt='yyyy-MM-dd hh:mm:ss']
 * @return {*} 
 */
export function formatDate(dateStr, fmt = 'yyyy-MM-dd hh:mm:ss') {
    if (!dateStr) return;
    const date = new Date(dateStr);
    const o = {
        'M+': date.getMonth() + 1, // 月份
        'd+': date.getDate(), // 日
        'h+': date.getHours(), // 小时
        'm+': date.getMinutes(), // 分
        's+': date.getSeconds(), // 秒
        'q+': Math.floor((date.getMonth() + 3) / 3), // 季度
        S: date.getMilliseconds(), // 毫秒
    };

    if (/(y+)/.test(fmt)) { fmt = fmt.replace(RegExp.$1, (`${date.getFullYear()}`).substr(4 - RegExp.$1.length)); }
    for (const k in o) {
        if (new RegExp(`(${k})`).test(fmt)) { fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : ((`00${o[k]}`).substr((`${o[k]}`).length))); }
    }
    return fmt;
}

/**
 *
 *
 * @export 获取当前时间并格式化
 * @param {*} isDate Boolean 为真返回时分秒 
 * @return {*} yyyy-MM-dd hh:mm:ss
 */
export function getNowTime(isDate = false) {
    var now = new Date();
    var year = now.getFullYear(); //得到年份
    var month = now.getMonth(); //得到月份
    var date = now.getDate(); //得到日期
    var hh = now.getHours();
    var mm = now.getMinutes();
    var ss = now.getSeconds();
    var hour = " " + hh + ":" + mm + ":" + ss + ""; //默认时分秒 如果传给后台的格式为年月日时分秒，就需要加这个，如若不需要，此行可忽略
    month = month + 1;
    month = month.toString().padStart(2, "0");
    date = date.toString().padStart(2, "0");
    var defaultDate = `${year}-${month}-${date}${hour}`;
    if (isDate) {
        var defaultDate = `${year}-${month}-${date}`;
    }
    return defaultDate;
}
/**
 *  验证失败定位
 * @returns 
 */
export function failCheckPosition() {
    setTimeout(() => {
        var isError = document.getElementsByClassName("is-error");
        isError[0].querySelector('input').focus();
    }, 100);
    return false;
}
/**
 * 获取星期
 * @returns 
 */
export function getWeek() {
    let weeks = [
      "星期日",
      "星期一",
      "星期二",
      "星期三",
      "星期四",
      "星期五",
      "星期六",
    ];
    let wk = new Date().getDay();
    return weeks[wk];
  }