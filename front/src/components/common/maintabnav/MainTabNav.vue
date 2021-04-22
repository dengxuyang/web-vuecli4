<template>
  <div class="maintabnav">
    <div class="logo">
      <img src="~@assets/images/title_logo.png" alt="" srcset="" />
      <span>一机游管理平台</span>
    </div>
    <div class="infobox">
      <span>{{ date }}</span>
      <span>{{ week }}</span>
      <span>{{ time }}</span>
      <span> 管理员</span>
      <span><i class="el-icon-arrow-down"></i></span>
    </div>
    <!-- 顶部主导航 -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      activeIndex: "1",
      activeIndex2: "1",
      time: this.formatDate(new Date(), "hh:mm:ss"),
      date: this.formatDate(new Date(), "yyyy-MM-dd"),
      week: this.getWeek(),
    };
  },
  methods: {
    handleSelect(key, keyPath) {
      console.log(key, keyPath);
    },
    //格式化时间
    formatDate(dateStr, fmt = "yyyy-MM-dd hh:mm:ss") {
      if (!dateStr) return;
      const date = new Date(dateStr);
      const o = {
        "M+": date.getMonth() + 1, // 月份
        "d+": date.getDate(), // 日
        "h+": date.getHours(), // 小时
        "m+": date.getMinutes(), // 分
        "s+": date.getSeconds(), // 秒
        "q+": Math.floor((date.getMonth() + 3) / 3), // 季度
        S: date.getMilliseconds(), // 毫秒
      };

      if (/(y+)/.test(fmt)) {
        fmt = fmt.replace(
          RegExp.$1,
          `${date.getFullYear()}`.substr(4 - RegExp.$1.length)
        );
      }
      for (const k in o) {
        if (new RegExp(`(${k})`).test(fmt)) {
          fmt = fmt.replace(
            RegExp.$1,
            RegExp.$1.length == 1 ? o[k] : `00${o[k]}`.substr(`${o[k]}`.length)
          );
        }
      }
      return fmt;
    },
    getWeek() {
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
    },
  },
  mounted() {
    let _this = this; // 声明一个变量指向Vue实例this，保证作用域一致
    this.timer = setInterval(() => {
      _this.time = this.formatDate(new Date(), "hh:mm:ss"); // 修改数据date
    }, 1000);
  },
  beforeDestroy() {
    if (this.timer) {
      clearInterval(this.timer); // 在Vue实例销毁前，清除我们的定时器
    }
  },
};
</script>

<style lang="scss"  scoped >
.maintabnav {
  box-shadow: 0px 0px 10px #000000;
}
.logo > img {
  vertical-align: middle;
  margin-left: 24px;
  margin-right: 10px;
  margin-top: -10px;
}
.logo > span {
  margin-right: 112px;
  font-size: 22px;
}

.infobox {
  margin-left: auto;
  margin-right: 50px;
  font-size: 13px;
  span {
    margin-left: 8px;
    img {
      margin-left: 3px;
    }
  }
}
</style>