<template>
  <!-- 数据资源 左侧导航栏 -->
  <div class="leftnav">
    <div class="colspan" @click="isCollapse = !isCollapse">
      <i v-show="!isCollapse" class="el-icon-caret-left iconcollapse"></i>
      <i v-show="isCollapse" class="el-icon-caret-right iconcollapse"></i>
    </div>
    <div class="menu_box">
      <el-menu
        :default-active="defaultActive"
        mode="vertical"
        class="el-menu-vertical-demo"
        @open="handleOpen"
        @close="handleClose"
        :collapse="isCollapse"
        unique-opened
        ref="refmenu"
      >
        <fragment v-for="item in leftNavData" :key="item.index">
          <el-menu-item
            v-if="!item.childe"
            :index="item.index"
            @click="menuClick(item)"
            class="one_menu_item"
          >
            <i :class="item.icon"></i>
            <span slot="title" style>{{ item.name }}</span>
          </el-menu-item>
          <!-- 多级菜单 -->
          <el-submenu :ref="'submenu' + item.index" v-else :key="item.index" :index="item.index">
            <template slot="title">
              <i style="color: #ffffff" :class="item.icon"></i>
              <span slot="title">{{ item.name }}</span>
            </template>
            <el-menu-item
              v-for="itemc in item.childe"
              :key="itemc.index"
              :index="itemc.index"
              @click="menuClick(itemc)"
              class="submenu_item"
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
      defaultActive: "home",
    };
  },

  methods: {
    handleOpen(key, keyPath) {
      //展开菜单时 默认选择第一项子菜单
      let submenuDom = this.$refs["submenu" + key][0];
      //当菜单不处于活跃状态时选中
      if (!submenuDom.active) {
        //解决js线程阻塞ui线程 菜单卡顿问题
        setTimeout(() => {
          submenuDom.$children[0].$el.click();
        }, 350);

      }
    },
    handleClose(key, keyPath) { },

    //点击菜单
    menuClick(item) {
      let index = item.index,
          name = item.name,
          isRouter = item.isRouter;
      this.$store.commit("setcurrentNav", { index, name });
      if (isRouter) {
        this.$router.push({ name: index });
        //收起展开的submenu
       let openedMenus= this.$refs['refmenu'].openedMenus
       openedMenus.forEach(i => {
        this.$refs['refmenu'].close(i)
       });
      
      } else if (this.$route != "modelmanage") {
        this.$router.push({ name: "modelmanage" });
      }
    },
  },
};
</script>

<style scoped lang="scss">
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
.el-menu {
  background-color: unset;
}
.el-menu-item.submenu_item.is-active {
  color: #499afe;
  background-color: #ffffff;
  span {
    border-bottom: 2px solid #499afe;
  }
}
.submenu_item span {
  margin-left: 8px;
  padding-bottom: 5px;
}
.el-submenu__title:hover {
  color: #e70f0f;
}

.one_menu_item.is-active {
  background-color: #1b76e8 !important;
  color: #ffffff;
  border-bottom: 0px solid;
}
.one_menu_item.el-menu-item:hover {
  // color: #ffffff;
  background-color: #1b76e8 !important;
}
.one_menu_item.el-menu-item {
  color: #ffffff;
  padding-left: 0px;
}
.el-submenu.is-active {
  background-color: #1b76e8 !important;
}
</style>

