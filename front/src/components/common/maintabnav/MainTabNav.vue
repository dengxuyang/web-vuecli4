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
      <span
        @mouseenter="isShowLogout = true"
        @mouseleave="isShowLogout = false"
      >
        <span class="showout" @click="isShowLogout = !isShowLogout">
          <span> 管理员</span>
          <span>
            <i v-if="!isShowLogout" class="el-icon-arrow-down"></i>
            <i v-else class="el-icon-arrow-up"></i>
          </span>
        </span>
        <transition name="slide-fade">
          <div v-if="isShowLogout" class="logout" @click="logout">退出登录</div>
        </transition>
      </span>
    </div>

    <!-- 顶部主导航 -->
  </div>
</template>

<script>
import { logout } from "@/login/conf/commonFunc.js";
import { formatDate ,getWeek} from "@/common/publicmethods"
export default {
  data() {
    return {
      activeIndex: "1",
      activeIndex2: "1",
      time: formatDate(new Date(), "hh:mm:ss"),
      date: formatDate(new Date(), "yyyy-MM-dd"),
      week: getWeek(),
      isShowLogout: false,
    };
  },
  methods: {
    logout() {
      logout();
    },
    handleSelect(key, keyPath) {
      console.log(key, keyPath);
    },
   
  },
  mounted() {
    let _this = this; // 声明一个变量指向Vue实例this，保证作用域一致
    this.timer = setInterval(() => {
      _this.time = formatDate(new Date(), "hh:mm:ss"); // 修改数据date
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
.logout {
  position: absolute;
  right: 40px;
  top: 60px;
  z-index: 99;
  width: 150px;
  height: 55px;
  text-align: center;
  background-color: #0369e6;
  font-size: 14px;
  cursor: pointer;
}
.showout {
  cursor: pointer;
  display: inline-block;
  height: 60px;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

/* 可以设置不同的进入和离开动画 */
/* 设置持续时间和动画函数 */
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active for below version 2.1.8 */ {
  transform: translateX(30px);
  opacity: 0;
}
</style>