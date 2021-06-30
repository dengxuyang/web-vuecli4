<template>
  <div>
    <el-tabs
      type="border-card"
      v-loading="loading"
      element-loading-text="拼命加载中"
      v-model="activeName"
      @tab-remove="removeTab"
      @tab-click="handleClick"
    >
      <el-tab-pane
        :closable="item.closable"
        v-for="(item, index) in tabitem"
        :key="index"
        :name="item.name"
        :label="item.label"
      >
        <slot :name="item.label"></slot>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
export default {
  props: ["tabitem", "loading"],
  data() {
    return {
      activeName: this.tabitem[0].name,
    };
  },

  methods: {
    handleClick(tab, event) {
      //console.log(tab, event);
      this.$emit("handleTabClick", tab);
    },
    removeTab(name) {
      this.$emit('closeTab')
      this.tabitem.forEach((element, index) => {
        if (element.name == name) {
          this.tabitem.splice(index, 1);
        }
      });
      this.activeName = this.tabitem[0].name;

    },
  },
};
</script>

<style lang="scss">
</style>