<template>
  <div>
    <el-tabs v-model="activeName2" type="card" @tab-click="handleClick">
      <el-tab-pane  v-for="(item,index) in tabitem" :key='index' :label="item.label"><slot :name="item.label"></slot> </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
export default {
  props: ['tabitem'],
  data() {
    return {
      activeName2: "0",
    };
  },
  methods: {
    handleClick(tab, event) {
      console.log(tab, event);
    },
  },
};
</script>

<style lang="scss">
</style>