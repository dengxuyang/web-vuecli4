<template>
  <!-- 表格组件 -->
  <div class="tablecontaner">
    <el-table
      ref="table"
      height="calc(100vh - 235px)"
      @selection-change="handleSelectionChange"
      :row-class-name="tableRowClassName"
      tooltip-effect="dark"
      :data="tableData"
      v-loading="loading"
      element-loading-text="拼命加载中"
      class="tablepad"
      :row-style="{ height: '36px' }"
      :cell-style="{ padding: '0px' }"
      :header-row-style="{ height: '20px' }"
      v-if="tableColumn.length != 0"
    >
      <el-table-column type="selection" width="55"> </el-table-column>
      <el-table-column
        v-for="item in tableColumn"
        :key="item.row_id"
        align="center"
        :prop="item.prop"
        :label="item.label"
        min-width="150"
        show-overflow-tooltip
        :fixed="item.fixed"
      >
        <template slot-scope="scope">
          <!-- 序号显示 -->
          <span v-if="item.index"
            ><el-link
              v-if="item.fristEnten"
              @click="$emit(item.func, scope.row, getEnterFiled())"
            >
              {{ scope["$index"] + 1 }}</el-link
            >
            <span v-else>
              {{ scope["$index"] + 1 }}
            </span></span
          >
          <!-- 操作列显示 -->
          <span v-else-if="item.isAction">
            <el-button
              class="btn-icon"
              v-for="actionItem in item.actionItem"
              :key="actionItem.text"
              @click="$emit(actionItem.func, scope.row, getEnterFiled())"
              type="text"
              size="small"
              v-show="istrue(actionItem.condition, scope.row)"
            >
              <el-tooltip
                effect="light"
                :enterable="false"
                :content="actionItem.text"
                placement="top"
              >
                <i :class="actionItem.icon"></i>
              </el-tooltip>
            </el-button>
            <el-popconfirm
              v-for="actionItem in item.popconfirmitem"
              :key="actionItem.text"
              :title="actionItem.title"
              @confirm="$emit(actionItem.func, scope.row)"
            >
              <el-button
                class="btn-icon"
                slot="reference"
                type="text"
                size="small"
                v-show="istrue(actionItem.condition, scope.row)"
                style="margin-left: 10px"
              >
                <el-tooltip
                  effect="light"
                  :enterable="false"
                  :content="actionItem.text"
                  placement="top"
                >
                  <i :class="actionItem.icon"></i>
                </el-tooltip>
              </el-button>
            </el-popconfirm>
          </span>
          <!-- 星级 针对特殊显示的处理 一般不用 （云野大数据平台使用） -->
          <span v-else-if="item.level">
            <el-rate
              :value="scope.row[item.prop]"
              disabled
              text-color="#ff9900"
              score-template="{value}"
            >
            </el-rate>
          </span>
          <!-- 默认显示 -->
          <span
            :style="
              !item.condition
                ? item.style
                : istrue(item.condition, scope.row)
                ? item.style
                : ''
            "
            v-else
          >
            <!-- 设置第一行选择 进入编辑 fristEnten：true func为执行的方法-->
            <el-link
              v-if="item.fristEnten"
              @click="$emit(item.func, scope.row, getEnterFiled())"
            >
              {{ scope.row[item.prop] }}</el-link
            >
            <!-- 设置状态 如1表示已启用 2表示未启用 传来一个map filterData 就会根据当前值去map中查询 -->
            <span v-else-if="item.map">{{
              scope.row[item.prop] | filterData(item.map)
            }}</span>
            <!-- 默认显示 -->
            <span v-else>
              {{ scope.row[item.prop] }}
            </span>
          </span>
        </template>
      </el-table-column>
    </el-table>
    <!-- 表格分页 -->
    <div class="footer" v-if="tableColumn.length != 0">
      <div>
        <el-button
          :disabled="!selectRows.length"
          type="primary"
          v-if="showBatchDel"
          size="mini"
          @click="$emit('batchDel', selectRows)"
          >批量删除</el-button
        >
      </div>
      <div>
        <el-pagination
          background
          :page-size="pageNum"
          layout="prev, pager, next, total"
          :total="pagetotal"
          :current-page.sync="pageNo"
          @current-change="
            (val) => {
              $emit('handlePageChange', val);
            }
          "
        >
        </el-pagination>
      </div>
      <div>
        <el-button type="primary" v-if="showExport" size="mini">导出</el-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    "tableData",
    "tableColumn",
    "pagenum",
    "pageno",
    "total",
    "showBatchDel",
    "showExport",
    "loading",
  ],
  watch: {
    total(val) {
      this.pagetotal = val;
    },
    pagenum(val) {
      this.pageNum = val;
    },
    pageno(val) {
      this.pageNo = val;
    },
  },
  data() {
    return {
      pagetotal: 0,
      pageNum: 10,
      pageNo: 0,
      selectRows: [],
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
    handleSelectionChange(rows) {
      this.selectRows = rows;
    },
    getEnterFiled() {
      let Filed = this.tableColumn[0].prop;
      return Filed;
    },
    //传来一个布尔条件字符串 执行返回
    istrue(condition, scope) {
      if (condition) {
        return eval(condition);
      }
      return true;
    },
    isShow(value = true) {
      return value;
    },
  },
  beforeUpdate() {
    this.$nextTick(() => {
      //在数据加载完，重新渲染表格
      if (this.$refs["table"]) {
        this.$refs["table"].doLayout();
      }
    });
  },
  filters: {
    //根据值返回相应数据
    filterData: function (value, map) {
      return map.get(Number(value)) ? map.get(Number(value)) : "";
    },
  },
};
</script>
<style>
.tablecontaner {
  height: calc(100vh - 160px);
}

.footer {
  display: flex;
  margin-top: 10px;
}
.footer > div {
  flex: 1;
}
.footer > div:nth-child(1) {
  text-align: left;
}
.footer > div:nth-child(2) {
  text-align: center;
}
.footer > div:nth-child(3) {
  text-align: right;
}
</style>