<template>
  <div>
    <MainTabBar
      @handleTabClick="handleTabClick"
      @closeTab="closeTab"
      :loading="showTabLoading"
      :activename="activename"
      :tabitem="tabitem"
      ref="tabbar"
    >
      <!-- 固定的插槽名称需要和tabitem的label对应-->
      <div :slot="currentNav.name">
        <el-row type="flex" class="row-bg top-box" justify="space-between" v-if="tableColumn.length">
          <el-col :span="6">
            <el-button
              size="mini"
              type="primary"
              @click="handleAdd"
              
              >新增</el-button
            >
          </el-col>

          <el-form  @submit.native.prevent :inline="true">
            <el-form-item label="名称：">
              <el-input size="mini" @keyup.enter.native="onQuery" clearable v-model="searchKey"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button
                size="mini"
                type="primary"
                @click="onQuery"
                icon="el-icon-search"
                >查询</el-button
              >
            </el-form-item>
          </el-form>
        </el-row>
        <TableComp
          :table-data="tableData"
          :table-column="tableColumn"
          :pagenum="pageNum"
          :total="pagetotal"
          :pageno="pageNo"
          :show-batch-del="true"
          :show-export="false"
          :loading="showTableLoading"
          @batchDel="batchDel"
          @handlePageChange="handlePageChange"
          @editRow="editRow"
          @delRow="delRow"
        ></TableComp>
      </div>
      <!-- 编辑页插槽 -->
      <div :slot="tabEditLabel">
        <FromData
          :show-filed-data="showFieldData"
          :selectdata="selectData"
          :form="form"
          :is-edit="isEdit"
          :rules="rules"
          @closetForm="closetForm"
          @submitForm="submitForm"
        ></FromData>
      </div>
    </MainTabBar>
  </div>
</template>

<script>
//标签页组件
import MainTabBar from "@components/content/maintabbar/MainTabBar";
//表格组件
import TableComp from "@components/common/tablecomp/TableComp";
//表单组件
import FromData from "./childecomponent/FromData";

import { isNum } from "@common/rules";
import {
  getResourcefield,
  queryDataOfResource,
  addDataOfResource,
  modifyDataOfResource,
  deleteDataOfResource,
  deleteBatchData,
} from "@network/basedata";

export default {
  components: {
    MainTabBar,
    TableComp,
    FromData,
  },
  data() {
    return {
      tabitem: [
        {
          name: "sjy", //移除时使用
          label: "",
        },
      ],
      //table
      tableData: [],
      tableColumn: [],
      pageNum: 10,
      pagetotal: 0,
      pageNo: 1,
      tabEditLabel: "",
      activename: "",
      typeList: [],
      showTableLoading: false, //表格加载中
      showTabLoading: false, //标签页加载中
      isEdit: false,
      currentNav: {},
      fieldData: [],
      form: {},
      selectData: {},
      fieldMap: {},
      rules: {},
      searchKey: "", //搜索关键字
      //配置需要根据id 转成文字的字段
      idToName: ["play_id", "payment", "parent_id", "modul_id"],
    };
  },
  created() {
    this.$bus.$off("imgUploaded", this.imgUploaded);
    this.$bus.$off("imgRemoved", this.imgRemoved);
  },
  mounted() {
    this.activename = "sjy";
    this.currentNav = this.$store.state.currentNav;
    this.$set(this.tabitem[0], "label", this.currentNav.name);
    this.getResourcefield();
    //接收事件总线
    this.$bus.$on("imgUploaded", this.imgUploaded);
    this.$bus.$on("imgRemoved", this.imgRemoved);
  },
  destroyed() {},
  computed: {
    listenCurrentNav() {
      //监听点击菜单
      this.searchKey = "";
      return this.$store.state.currentNav;
    },
    showFieldData() {
      return this.fieldData.filter((val) => {
        return val.show_type != "0";
      });
    },
  },
  watch: {
    //监听点击菜单
    listenCurrentNav(val) {
      this.$nextTick(() => {
        this.$set(this.tabitem[0], "label", val.name);
      });

      // console.log(this.form);
      this.currentNav = val;
      this.getResourcefield();
      this.closetForm();
    },
  },
  methods: {
    //获取资源字段
    getResourcefield() {
      this.showTabLoading = true;
      this.pageNo = 1;
      let params = {
        directory_code: this.currentNav.index,
      };
      getResourcefield(params)
        .then((result) => {
          this.fieldData = result.data.list;
          if (
            this.fieldData == 0 ||
            this.fieldData[0].code != this.currentNav.index
          ) {
            this.tableData = [];
            this.tableColumn = [];
            this.showTabLoading = false;
          } else {
            this.handleSelectData();
            this.pagetotal = result.total;
          }
        })
        .catch((err) => {});
    },
    //点击查询按钮
    onQuery() {
      this.pagetotal = 0;
      this.queryDataOfResource();
    },
    //获取表格数据
    queryDataOfResource() {
      if (!this.showTabLoading) {
        this.showTabLoading = true;
      }
      let params = {
        data: { [this.tableColumn[0].prop]: this.searchKey, is_check: 1 },

        pageNo: this.pageNo,
        pageNum: this.pageNum,
        directory_code: this.currentNav.index,
      };
      queryDataOfResource(params)
        .then((result) => {
          if (result.directory_code == this.currentNav.index) {
            this.tableData = result.data;
            this.pagetotal = result.total;
            this.showTabLoading = false;
          } else {
            this.showTabLoading = false;
          }
        })
        .catch((err) => {
          this.showTabLoading = false;
        });
    },
    //处理显示的字段
    handleColumn(dataField) {
      this.tableColumn = [];
      let showColumn = dataField.filter((val) => {
        return val.is_intable == "1";
      });
      showColumn.forEach((element, index) => {
        let filedObj = {
          label: "",
          prop: "",
        };
        filedObj.label = element.name;
        filedObj.prop = element.en_name;
        if (index == 0) {
          filedObj.fristEnten = true; //首列点击
          filedObj.func = "editRow"; //点击的方法
        }

        if (
          this.idToName.includes(element.en_name) &&
          (element.show_type == "2" || element.show_type == "4")
        ) {
          let maparr = [],
            dictionary = this.selectData[element.en_name];
          if (dictionary) {
            dictionary.forEach((item) => {
              maparr.push([item.row_id, item.name]);
            });
            filedObj.map = new Map(maparr);
          }
        }

        this.tableColumn.push(filedObj);
      });
      this.tableColumn.push({
        label: "操作",
        //是否是操作
        isAction: true,
        fixed: "right",
        //操作的按钮与方法
        actionItem: [
          {
            text: "编辑", //按钮的文本
            icon: "el-icon-edit",
            type: "primary", //按钮类型
            func: "editRow", //按钮的方法
          },
        ],
        //带确认的按钮
        popconfirmitem: [
          {
            text: "删除",
            icon: "el-icon-delete",
            func: "delRow",
            title: "确定删除这条数据吗？",
          },
        ],
      });
    },
    //处理遍历fromdata数据
    handleSelectData() {
      //初始化rules
      Object.keys(this.rules).forEach((key) => {
        this.rules[key] = "";
      });
      this.showFieldData.forEach((item, index) => {
        //获取字段类型map 在判断是那种数据类型中使用
        this.fieldMap[item.en_name] = item.type;
        //单选，选择框 没有关联变 默认为是否
        if ((item.show_type == 2 || item.show_type == 4) && !item.associate) {
          this.selectData[item.en_name] = [
            {
              name: "是",
              row_id: 1,
            },
            {
              name: "否",
              row_id: 0,
            },
          ];
        } else if (
          item.associate &&
          item.associate.length != 0 &&
          (item.show_type == 2 ||
            item.show_type == 3 ||
            item.show_type == 4 ||
            item.show_type == 9)
        ) {
          this.queryDataOfResourceForSelect(item.en_name, item.associate);
        }
        //向字段中添加rule
        let ruleItem;
        if (item.type.indexOf("int") != -1) {
          ruleItem = { validator: isNum, trigger: "blur" };
          this.rules[item.en_name] = [];
          this.rules[item.en_name].push(ruleItem);
        }
        if (item.restraint == 1) {
          ruleItem = {
            required: true,
            message: "请输入" + item.name,
            trigger: "blur",
          };
          if (item.show_type == 4) {
            ruleItem = {
              required: true,
              message: "请选择" + item.name,
              trigger: "blur",
            };
          } else if (item.show_type == 6) {
            ruleItem = {
              required: true,
              message: "请上传图片",
              trigger: "blur",
            };
          }

          this.rules[item.en_name] = [];
          this.rules[item.en_name].push(ruleItem);
        }
      });

      this.handleColumn(this.fieldData);
      this.queryDataOfResource();
    },
    //查询资源对应数据用于选择框
    queryDataOfResourceForSelect(fieldName, resourceCode) {
      let params = {
        data: { is_check: 1 },
        pageNo: this.pageNo,
        pageNum: this.pageNum,
        directory_code: resourceCode,
      };
      queryDataOfResource(params)
        .then((res) => {
          if (res.errcode == 0) {
            this.selectData[fieldName] = [];
            this.selectData[fieldName] = res.data;
            // this.typeData[fieldName] = {};
            // for (const i of this.selectData[fieldName]) {
            //   this.typeData[fieldName][i.row_id] = i.name;
            // }
            this.handleColumn(this.fieldData);
          }
        })
        .catch((err) => {
          this.showTabLoading = false;
        });
    },
    handlePageChange(val) {
      this.pageNo = val;
      this.queryDataOfResource();
    },
    //点击编辑
    editRow(row, field) {
      this.form = JSON.parse(JSON.stringify(row));
      //点击编辑时标签页title
      this.tabEditLabel = row[field] + "-编辑";
      this.activename = "editpage";
      this.$refs.tabbar.activeName = "editpage";
      this.isEdit = true;
      if (!this.isIncludes(this.activename)) {
        this.tabitem.push({
          name: "editpage",
          label: this.tabEditLabel,
          closable: true,
        });
      } else {
        this.tabitem[1].label = this.tabEditLabel;
      }
    },
    //点击删除
    delRow(row) {
      this.deleteData(row);
    },
    //批量删除
    batchDel(rows) {
      this.$confirm("此操作将永久删除该数据, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning",
      })
        .then(() => {
          let params = {
            rows: rows.map((val) => {
              return val.row_id;
            }),
            directory_code: this.currentNav.index,
          };
          deleteBatchData(params).then((res) => {
            if (res.errcode == 0) {
              this.$message({
                showClose: true,
                message: "数据删除成功",
                type: "success",
              });
              this.queryDataOfResource();
            } else {
              this.$message.error(res.errMsg);
            }
          });
        })
        .catch(() => {
          // this.$message({ type: 'info', message: '已取消删除' });
        });
    },
    //点击添加按钮
    handleAdd() {
      this.tabEditLabel = "新增";
      this.activename = "editpage";
      this.$refs.tabbar.activeName = "editpage";
      this.isEdit = false;
      if (!this.isIncludes(this.activename)) {
        //没打开就添加一个
        this.tabitem.push({
          name: "editpage",
          label: this.tabEditLabel,
          closable: true,
        });
      } else {
        this.tabitem[1].label = this.tabEditLabel; //打开就直接变个标题 合理！这个想法恒河里
      }
    },
    //点击标签页
    handleTabClick(tab) {
      this.activename = tab.name;
    },
    //关闭标签页
    closeTab() {
      for (const key in this.form) {
        this.form[key] = "";
      }
    },
    //点击关闭按钮
    closetForm() {
      this.form = {};
      this.$refs["tabbar"].removeTab("editpage");
    },
    //点击保存
    submitForm(fromData) {
      let fromDataC = this.clearSubmitData(fromData);
      console.log(fromDataC);
      if (this.isEdit) {
        this.modifyData(fromDataC);
      } else {
        this.addData(fromDataC);
      }
    },
    //处理上传前的表单  int类型 为空都写为0 删除create_time
    clearSubmitData(fromData) {
      delete fromData.create_time;
      //删除空字段
      Object.keys(fromData).map((item) => {
        let isint = false;
        if (this.fieldMap.hasOwnProperty(item)) {
          isint = this.fieldMap[item].indexOf("int") != -1;
        }
        if (isint && fromData[item] === "") {
          fromData[item] = 0;
        }
        return true;
      });
      return fromData;
    },
    //修改数据
    modifyData(fromData) {
      let params = { data: fromData, directory_code: this.currentNav.index };
      modifyDataOfResource(params)
        .then((result) => {
          if (result.errCode == 0) {
            this.$message({
              message: "修改成功",
              type: "success",
            });
            this.queryDataOfResource();
            this.closetForm();
          }
        })
        .catch((err) => {});
    },
    //添加数据
    addData(fromData) {
      let params = { data: fromData, directory_code: this.currentNav.index };
      addDataOfResource(params)
        .then((result) => {
          if (result.errCode == 0) {
            this.$message({
              message: "新增成功",
              type: "success",
            });
            this.getResourcefield();
            this.closetForm();
          }
        })
        .catch((err) => {});
    },
    //删除数据
    deleteData(row) {
      let pamars = {
        data: { row_id: row.row_id },
        directory_code: this.currentNav.index,
      };
      deleteDataOfResource(pamars)
        .then((result) => {
          if (result.errCode == 0) {
            this.$message({
              message: "删除成功",
              type: "success",
            });
            this.queryDataOfResource();
          }
        })
        .catch((err) => {});
    },
    //判断标签页是否已经打开
    isIncludes(value) {
      return (
        this.tabitem.filter((val) => {
          return [value].includes(val.name);
        }).length > 0
      );
    },
    imgUploaded(res, name) {
      this.$set(this.form, name, res.path);
      //  this.form[name] = res.path
    },
    imgRemoved(name) {
      this.form[name] = "";
    },
  },
};
</script>

<style lang='scss' scoped>
</style>