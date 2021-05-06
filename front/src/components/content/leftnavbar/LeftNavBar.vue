<template>
  <!-- 数据资源 左侧导航栏 -->
  <div class="leftnav">
    <div class="colspan" @click="isCollapse = !isCollapse">
      <i v-show="!isCollapse" class="el-icon-caret-left iconcollapse"></i>
      <i v-show="isCollapse" class="el-icon-caret-right iconcollapse"></i>
    </div>
    <div class="menu_box">
      <el-menu
        default-active="1"
        mode="vertical"
        class="el-menu-vertical-demo"
        @open="handleOpen"
        @close="handleClose"
        background-color="#499afe"
        text-color="#fff"
        active-text-color="#fce169"
        :collapse="isCollapse"
        unique-opened
      >
        <fragment v-for="item in leftNavData" :key="item.index">
          <el-menu-item
            v-if="!item.childe"
            :index="item.index"
            @click="menuClick(item)"
          >
            <i class="el-icon-c-scale-to-original"></i>
            <span slot="title" style="">{{ item.name }}</span>
          </el-menu-item>
          <!-- 多级 -->
          <el-submenu v-else :key="item.index" :index="item.index">
            <template slot="title">
              <i style="color: #ffffff" class="el-icon-document"></i>
              <span slot="title">{{ item.name }}</span>
            </template>
            <el-menu-item
              v-for="itemc in item.childe"
              :key="itemc.index"
              :index="itemc.index"
              @click="menuClick(itemc)"
            >
              <span slot="title">{{ itemc.name }}</span>
            </el-menu-item>
          </el-submenu>
        </fragment>
      </el-menu>
    </div>
  </div>
</template>

<script>
import { leftNavData } from "./conf/leftNavData.js";
export default {
  data() {
    return {
      isCollapse: false,
      openeds: [1],
      leftNavData: leftNavData,
    };
  },

  methods: {
    handleOpen(key, keyPath) {
      // console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      // console.log(key, keyPath);
    },
    menuClick(item) {
      let index = item.index,
        name = item.name,
        isRouter = item.isRouter;
      this.$store.commit("setcurrentNav", { index, name });
      if (isRouter) {
        this.$router.push({ name: index });
      } else if (this.$route != "modelmanage") {
        this.$router.push({ name: "modelmanage" });
      }
    },
  },
};
</script>

<style scoped>
.el-menu-vertical-demo:not(.el-menu--collapse) {
  width: 215px;
}
.el-menu-item i {
  color: #ffffff;
}
.menu_box {
  height: 100%;
  overflow-y: auto;
}
.menu_box::-webkit-scrollbar {
  width: 0 !important;
}
.menu_box {
  -ms-overflow-style: none;
}
.el-aside .el-submenu .el-menu-item {
  background-color: #ffffff;
}
</style>

