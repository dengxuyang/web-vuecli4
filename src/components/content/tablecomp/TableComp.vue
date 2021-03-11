<template>
  <div>
    <el-table
      :row-class-name="tableRowClassName"
      :data="tableData"
      class="tablepad"
      :row-style="{ height: '36px' }"
      :cell-style="{ padding: '0px' }"
      :header-row-style="{ height: '36px' }"
    >
      <el-table-column align="center" prop="date" label="日期" width="180"> </el-table-column>
      <el-table-column align="center" prop="name" label="姓名" width="180"> </el-table-column>
      <el-table-column align="center" prop="address" label="地址"> </el-table-column>
    </el-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tableData: [
        {
          date: "2016-05-02",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1518 弄",
        },
        {
          date: "2016-05-04",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1517 弄",
        },
        {
          date: "2016-05-01",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1519 弄",
        },
        {
          date: "2016-05-03",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1516 弄",
        },
      ],
    };
  },
  methods: {
    tableRowClassName({ row, rowIndex }) {
      if (rowIndex % 2 == 0) {
        return "rowlight";
      } else {
        return "rowdeep";
      }
    },
  },
};
</script>
<style>
.tablepad {
}
</style>