<template>
  <div>
    <!-- 文件上传 -->
    <el-upload
      ref="upload"
      class="upload-demo"
      :limit="1"
      action="/back/gthmmc/gthmmc/index.php?m=amobiletour&c=uploadWeb&a=fileUpload"
      :on-success="(res, file) => handleAvatarSuccess(res, filedname)"
      :on-progress="fileProgress"
      name="Filedata"
      :file-list="fileList"
      list-type="text"
      :show-file-list="false"
    >
      <el-button size="medium" type="primary">点击上传</el-button>
      <div v-show="!filesrc" slot="tip" class="el-upload__tip">
        暂无文档 仅允许上传文档类型
      </div>
    </el-upload>
    <a
      v-show="filesrc !== ''"
      :download="(filesrc ? '/back/gthmmc' : '') + filesrc"
      :href="(filesrc ? '/back/gthmmc' : '') + filesrc"
      >{{ filesrc | filepathfilter }}</a
    >
    <el-tooltip
      v-show="filesrc"
      style="margin-left: 20px"
      content="删除"
      :enterable="false"
      effect="light"
      placement="top"
    >
      <el-link
        icon="el-icon-delete"
        :underline="false"
        type="primary"
        @click="handleRemove(filedname)"
      ></el-link>
    </el-tooltip>
  </div>
</template>

<script>
export default {
  props: ["filesrc", "filedname"],
  data() {
    return {
      dialogVisible: {},
      fileList: [],
    };
  },

  methods: {
    handleAvatarSuccess(res, name) {
     
      if(res.result=="1"){
        this.$bus.$emit("imgUploaded", res, name);
      }else{
        this.fileList = [];
        this.$message({
              message: res.message,
              type: "info",
            });
      }
    },

    handleRemove(itemname) {
   
      this.$bus.$emit("imgRemoved", itemname);
    },
    previewImg(itemname) {
      this.$set(this.dialogVisible, itemname, true);
    },
    fileProgress(e){
     console.log(e);
    }
  },
  filters: {
    filepathfilter: function (value) {
      if (value) {
        let index = value.lastIndexOf("/");
        value = value.substring(index + 1, value.length);
        return value;
      }
    },
  },
};
</script>

<style scoped>
</style>