const path = require("path");
const resolve = dir => path.join(__dirname, dir);
const IS_PROD = ["production", "prod"].includes(process.env.NODE_ENV);


//富文本



module.exports = {
    publicPath: IS_PROD ? '././' : '/',



    chainWebpack: config => {
        // 添加别名
        config.resolve.alias
            .set("@", resolve("src"))
            .set("@assets", resolve("src/assets"))
            .set("@components", resolve("src/components"))
            .set("@views", resolve("src/views"))
            .set("@network", resolve("src/network"))
            .set("@common", resolve("src/common"))
        config.plugin('html').tap(args => {
            args[0].title = '一机游管理平台';
            return args;
        })

    },
    devServer: {
        // Paths
        host: '0.0.0.0',
        port: '8080',
        https: false,
        open: true,
        proxy: {
            '/back': {
                target: 'http://localhost',
                changeOrigin: true,
                pathRewrite: {
                    '^/back': '/back'
                }
            }
        },


    },

    lintOnSave: false,

};