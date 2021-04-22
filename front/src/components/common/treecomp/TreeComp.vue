<template>
  <div class="tree_container">
    <div class="tree_title"><i class="el-icon-s-fold"></i>数据模型</div>
    <div class="tree_detail">
      <el-tree
        :data="data"
        :props="defaultProps"
        @node-click="handleNodeClick"
      ></el-tree>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [
        {
          label: "一级 1",
          children: [
            {
              label: "二级 1-1",
              children: [
                {
                  label: "三级 1-1-1",
                },
              ],
            },
          ],
        },
        {
          label: "一级 2",
          children: [
            {
              label: "二级 2-1",
              children: [
                {
                  label: "三级 2-1-1",
                },
              ],
            },
            {
              label: "二级 2-2",
              children: [
                {
                  label: "三级 2-2-1",
                },
              ],
            },
          ],
        },
        {
          label: "一级 3",
          children: [
            {
              label: "二级 3-1",
              children: [
                {
                  label: "三级 3-1-1",
                },
              ],
            },
            {
              label: "二级 3-2",
              children: [
                {
                  label: "三级 3-2-1",
                },
              ],
            },
          ],
        },
      ],
      defaultProps: {
        children: "children",
        label: "label",
      },
    };
  },
  methods: {
    handleNodeClick(data) {
      console.log(data);
    },
  },
};
</script>

<style lang="scss" scoped>
.tree_container {
  background-color: #ffffff;
  box-shadow: 0 2px 4px 0px #dcdfe6;
  border: 1px solid #dcdfe6;
  border-radius: 2px;
}
.tree_title {
  color: #499afe;
  font-size: 14px;
  padding: 0 20px;
  height: 40px;
  line-height: 40px;
  i {
    margin-right: 5px;
  }
}
.tree_detail{
    // padding: 0 20px;
    padding-left: 10px;
}
</style>