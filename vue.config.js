const path = require("path");
const resolve = dir => path.join(__dirname, dir);
const IS_PROD = ["production", "prod"].includes(process.env.NODE_ENV);
module.exports = {
    publicPath: IS_PROD ? '././' : '/',
    chainWebpack: config => {
        // 添加别名
        config.resolve.alias
            .set("@", resolve("src"))
            .set("@assets", resolve("src/assets"))
            .set("@components", resolve("src/components"))
            .set("@views", resolve("src/views"))
        config.plugin('html').tap(args => {
            args[0].title = '旅游大数据管理平台';
            return args;
        })
    },


    lintOnSave: false,

};