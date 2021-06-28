<template>
  <div class="fromContainer">
    <el-form
      :model="form"
      status-icon
      :rules="rules"
      ref="form"
      label-width="100px"
      size="mini"
      labelWidth="auto"
    >
      <!-- left -->
      <el-row :gutter="20">
        <el-col :sm="24" :md="18" :lg="18" :xl="12" :offset="0">
          <el-form-item
            v-for="item in showFiledData"
            :key="item.row_id"
            :label="`${item.name}：`"
            :prop="item.en_name"
          >
            <!-- 文本框 -->
            <el-input
              v-if="item.show_type == 1"
              v-model="form[item.en_name]"
            ></el-input>
            <!-- 单选按钮 -->
            <fragment v-if="item.show_type == 2">
              <el-radio
                v-for="radio in selectdata[item.en_name]"
                v-model="form[item.en_name]"
                :label="radio.row_id"
                :key="radio.row_id"
                >{{ radio.name }}</el-radio
              >
            </fragment>
            <!-- 多选按钮 -->
            <el-checkbox-group
              v-if="item.show_type == 3"
              v-model="checkList[item.en_name]"
              @change="handleChange(item.en_name)"
            >
              <el-checkbox
                v-for="checkbox in selectdata[item.en_name]"
                :key="checkbox.row_id"
                :label="checkbox.row_id"
                >{{ checkbox.name }}</el-checkbox
              >
            </el-checkbox-group>
            <!-- 选择框 -->
            <el-select
              v-if="item.show_type == 4"
              v-model="form[item.en_name]"
              placeholder="请选择"
              style="width: 100%"
              clearable
            >
              <el-option
                v-for="select in selectdata[item.en_name]"
                :key="select.row_id"
                :label="select.name ? select.name : select.name_chn"
                :value="select.row_id"
              >
              </el-option>
            </el-select>
            <!-- 多行文本框 -->
            <el-input
              v-else-if="item.show_type == 5"
              v-model="form[item.en_name]"
              type="textarea"
              size="medium"
              rows="4"
              class="textareaNOPut"
            ></el-input>
            <ImageUpload
              v-else-if="item.show_type == 6"
              :imgsrc="form[item.en_name]"
              :filedname="item.en_name"
            ></ImageUpload>
            <!-- 时间选择器 -->
            <el-date-picker
              v-else-if="item.show_type == 7"
              v-model="form[item.en_name]"
              value-format="yyyy-MM-dd"
              format="yyyy-MM-dd"
              type="date"
            ></el-date-picker>
             <!-- 富文本 -->
           <editor  v-model="form[item.en_name]" :isClear="isClear" v-else-if="item.show_type == 8"></editor>
         
            <!-- 文件上传 -->
            <FileUpload
              v-else-if="item.show_type == 10"
              :filesrc="form[item.en_name]"
              :filedname="item.en_name"
            ></FileUpload>
           
          </el-form-item>
        </el-col>
      </el-row>
      <el-form-item>
        <el-button type="primary" @click="clickSave">保存</el-button>
        <el-button @click="$emit('closetForm')">关闭</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { getNowTime, failCheckPosition } from "@common/publicmethods";
import ImageUpload from "./ImageUpload";
import FileUpload from "./FileUpload";
import editor from '@components/common/editor/editor'
export default {
  components: {
    ImageUpload,
    FileUpload,
    editor
  },
  props: {
    showFiledData: {
      type: Array,
    },
    form: {
      type: Object,
      default: {},
    },
    selectdata: {
      type: Object,
      default: () => {
        return {};
      },
    },
    isEdit: {
      type: Boolean,
      default: false,
    },
    rules: {
      type: Object,
      default: () => {
        return {};
      },
    },
  },
  data() {
    return {
      //  rules: CleanDataManageRules,
      isClear:false
    };
  },
  mounted() {
    this.handleBackView();
  },
  methods: {
   
    //处理回显
    handleBackView() {
      //判断是否为新增

      //处理radio 添加时默认
      for (const i of this.showFiledData) {
        if (!this.isEdit) {
          if (i.show_type == "2" && !i.associate) {
            this.$set(this.form, i.en_name, 1);
          } else if (i.show_type == "4" && !i.associate) {
            this.form[i.en_name] = "1";
          }
          //转成数字
        } else {
          if (
            this.form[i.en_name] &&
            (i.show_type == "2" || i.show_type == "4")
          ) {
            if (Number(this.form[i.en_name])) {
              this.form[i.en_name] = Number(this.form[i.en_name]);
            }
          }
        }
      }
    },
    //点击关闭按钮
    closetForm() {
      this.$refs["tabbar"].removeTab("editpage");
    },
    closetForm() {},
    uploadAvatarProcess(event, index, name) {
      // this.loadprogress[index]["flag" + name] = true; // 显示进度条
      // setTimeout(() => {
      //   this.loadprogress[index]["percent" + name] = parseInt(event.percent); // 动态获取文件上传进度
      //   if (this.loadprogress[index]["percent" + name] >= 100) {
      //     this.loadprogress[index]["percent" + name] = 100;
      //     setTimeout(() => {
      //      // this.$set(this.loadprogress[index], "flag" + name, false);
      //       this.$forceUpdate();
      //     }, 1000); // 一秒后关闭进度条
      //   }
      // }, 1000);
    },

    clickSave() {
      this.$refs["form"].validate((valid) => {
        if (valid) {
          this.$emit("submitForm", this.form);
        } else {
          //验证失败定位失败位置
          failCheckPosition();
        }
      });
    },
  },
};
</script>

<style scoped>
.fromContainer {
  padding-left: 50px;
  height: calc(100vh - 150px);
  overflow-y: scroll;
  overflow-x: hidden;
}
</style>