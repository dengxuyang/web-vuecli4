import { oauthGetCurrentUser, getDataApiPower, getData } from "@network/token";
import store from '../../store'
import router from '../../router'
var code = getUrlParam("code");
var redirect_uri = document.URL;
var redirect_uri = 'http://blzh.likezou.com/';
var logout_uri = document.URL.replace(code, '');
const IS_PROD = ["production", "prod"].includes(process.env.NODE_ENV);
export function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0] == variable) {
            return pair[1];
        }
    }
    return false;
}
export function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}
export function logout() {
    var login_page = getUrlParam("login_page");
    var systemName;
    if (!login_page || login_page == "") {
        login_page = "jqx";
    }
    var username = getUrlParam("u");
    if (!username) {
        username = "";
    }
    var password = getUrlParam("p");
    if (!password) {
        password = "";
    }
    var logo = getUrlParam("l");
    if (!logo) {
        logo = "";
    }
    var title = getUrlParam("t");
    if (!title) {
        title = "";
    }
    store.commit("setLoginStatus", false);
    window.location =
        process.env.VUE_APP_Log_out +
        logout_uri +
        "&login_page=" +
        login_page +
        "&t=" +
        title +
        "&l=" +
        logo;
}
export function getLoginPage() {

    var code = getQueryVariable("code");

    var login_page = getUrlParam("login_page");
    var url = document.URL;
    if (IS_PROD) {
        if (!login_page || login_page == "") {
            login_page = "jqx";
            let urlarr = url.replace("http://", "").split("/");
            if (!urlarr[3].includes("login_page")) {
                urlarr[3] = urlarr[3].replace("#", '?login_page=' + login_page + "#")
            }
            url = "http://" + urlarr.join("/")
        }
    } else {
        if (!login_page || login_page == "") {
            login_page = "jqx";
            let urlarr = url.replace("http://", "").split("/");
            if (!urlarr[0].includes("login_page")) {
                urlarr[0] = urlarr[0] + '?login_page=' + login_page
            }
            url = "http://" + urlarr.join("")
        }
    }

    var username = getUrlParam("u");
    if (!username) {
        username = "";
    }
    var password = getUrlParam("p");
    if (!password) {
        password = "";
    }
    var logo = getUrlParam("l");
    if (!logo) {
        logo = "";
    }
    var title = getUrlParam("t");
    if (!title) {
        title = "";
    }


    if (!code || code == "") {
        redirect_uri = encodeURIComponent(url);
        window.location =
            process.env.VUE_APP_Log_in +
            "?client_id=appid&redirect_uri=" +
            redirect_uri +
            "&login_page=" +
            login_page +
            "&response_type=code&scope=read";
    } else {
        store.commit("setLoginStatus", true);
        router.push({ name: "Home" });
        //getuser()
    }
}
//业务代码 获取用户信息
function getuser() {
    /********************业务逻辑 根据业务写 */
    let params = {
        code: code,
        redirect_uri: redirect_uri,
    };
    //获取当前用户权限
    getDataApiPower({ destination_id: 531 })
        .then((result) => {
            let dataPorwer = result.data.list[0].righht;
            dataPorwer = JSON.parse(dataPorwer);
            store.commit("setDataPrower", dataPorwer.root);
            router.push("/basedata");
        })
        .catch((err) => {});
    //获取需要携带的token 请求接口的token
    getToken()
        .then((result) => {
            //获取用户信息
            oauthGetCurrentUser(params)
                .then((result) => {
                    if (result && result.errCode == "0") {
                        //获取成功 方法
                    } else {
                        var login_page = getUrlParam("login_page");
                        if (!login_page) {
                            login_page = "gc";
                        }
                        var username = getUrlParam("u");
                        if (!username) {
                            username = "";
                        }
                        var password = getUrlParam("p");
                        if (!password) {
                            password = "";
                        }
                        var logo = getUrlParam("l");
                        if (!logo) {
                            logo = "";
                        }
                        var title = getUrlParam("t");
                        if (!title) {
                            title = "";
                        }
                        var url = document.URL;
                        var arr = url.split("?");
                        var redirect_uri = arr[0];
                        //window.location = "http://www.ssoauth.com/ssoauth/j_spring_security_logout?redirect_uri=" + redirect_uri + "&login_page=" + login_page + "&t=" + title + "&l=" + logo;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        })
        .catch((err) => {});
}
export function getToken() {
    return new Promise((resolve, reject) => {
        let params = {
            grant_type: "client_credentials",
            appid: "appid",
            secret: "appsecret",
        };
        getData(params)
            .then((res) => {
                store.commit("setToken", res.access_token);
                resolve();
            })
            .catch((err) => {
                reject();
            });
    });
}