<template>
  <!-- 数据资源页面 -->
  <div class="home">
  
      <left-nav-bar />
   
    <div class="dataview">
      <router-view />
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import LeftNavBar from "@components/content/leftnavbar/LeftNavBar";
export default {
  name: "Home",
  components: {
    LeftNavBar,
  },
};
</script>
<style scoped>
.home {
  display: flex;
  height: calc(100vh - 60px);
 
}
.dataview{
  flex:1;
   overflow: hidden
  /* padding-top: 26px;
  padding-left:34px ; */
}
</style>