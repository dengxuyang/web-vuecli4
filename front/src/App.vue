<template>
  <div id="app">
    <main-tab-nav />
    <left-nav-bar />
    <div class="home">
      <div class="dataview">
        <router-view />
      </div>
    </div>
  </div>
</template>
<script>
import MainTabNav from "@components/common/maintabnav/MainTabNav";
import LeftNavBar from "@components/content/leftnavbar/LeftNavBar";

export default {
  name: "App",
  components: {
    MainTabNav,
    LeftNavBar,
  },
  created: function () {
    this.$router.push("/");
  },
};
</script>

<style>
@import "assets/css/base.css";
</style>
