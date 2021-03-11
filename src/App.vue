<template>
  <div id="app">
    <main-tab-nav/>  
    <router-view/>
  </div>
</template>
<script>
import  MainTabNav  from '@components/common/maintabnav/MainTabNav'
export default {
   name: "App",
   components: {
    MainTabNav,
  },
}
</script>

<style>
@import "assets/css/base.css";
</style>
