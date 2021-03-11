<template>
  <!-- 数据资源 左侧导航栏 -->
  <div class="leftnav">
    <div class="colspan" @click="isCollapse = !isCollapse">
      <i v-show='!isCollapse' class="el-icon-caret-left iconcollapse"></i>
      <i v-show='isCollapse' class="el-icon-caret-right iconcollapse"></i>
    </div>
    <el-menu
      default-active="1"
      mode="vertical"
      class="el-menu-vertical-demo"
      @open="handleOpen"
      @close="handleClose"
      background-color="#1a1e29"
      text-color="#fff"
      active-text-color="#ffd04b"
      router
      :collapse="isCollapse"
    >
      <el-menu-item index="1" route="/basedata">
        <i class="el-icon-location"></i>
        <span slot="title" style="">基础数据</span>
      </el-menu-item>
      <el-menu-item index="2" route="/realtimedata">
        <i class="el-icon-menu"></i>
        <span slot="title">实时数据</span>
      </el-menu-item>
      <el-menu-item index="3" route="/statisticsdata">
        <i class="el-icon-document"></i>
        <span slot="title">数据统计</span>
      </el-menu-item>
      <el-menu-item index="4" route="/reportdata">
        <i class="el-icon-setting"></i>
        <span slot="title">数据报告</span>
      </el-menu-item>
    </el-menu>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isCollapse: false,
    };
  },
  methods: {
    handleOpen(key, keyPath) {
      console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      console.log(key, keyPath);
    },
  },
};
</script>

<style scoped>
.leftnav {
  position: relative;
  /* width: 215px; */
  height: calc(100vh - 60px);
  background: url("~@assets/images/leftnavbg.png");
  background-size: contain;
  float: left;
}
.colspan {
  position: absolute;
  width: 10px;
  height: 20px;
  right: -10px;
  top: 20px;
  background-color: #7e8085;
  cursor: pointer;
  z-index: 99;
  border-radius: 0px 20px 20px 0px;

}
.el-menu-vertical-demo:not(.el-menu--collapse) {
  width: 215px;
}
.iconcollapse {
  position: absolute;
  font-size: 5px;
  color: #f6d602;
  top: 4.6px;
  left: -3px;
}
</style>

