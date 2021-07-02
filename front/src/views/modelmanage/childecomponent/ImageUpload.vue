<template>
  <div>
    <!-- 图片上传 -->
    <div v-show="imgsrc" class="avatar-uploader el-upload imgLoadBox">
      <img :src="(imgsrc ? '/back/gthmmc' : '') + imgsrc" class="avatar" />
      <div class="imgBoxmMask"></div>
      <i class="el-icon-delete" @click="handleRemove(filedname)"></i>
      <i class="el-icon-zoom-in" @click="previewImg(filedname)" :style="{ 'margin-left': '25%' }"></i>
    </div>
    <el-upload
      v-show="!imgsrc"
      class="avatar-uploader"
      name="Filedata"
      action="/back/gthmmc/gthmmc/index.php?m=amobiletour&c=uploadWeb&a=imageUpload"
      :on-success="(res, file) => handleAvatarSuccess(res, filedname)"
      list-type="picture"
      :show-file-list="false"
    >
      <img v-show="imgsrc" :src="imgsrc" class="avatar el-icon-plus" />

      <i class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>

    <el-dialog :visible.sync="dialogVisible[filedname]">
      <img width="100%" :src="(imgsrc ? '/back/gthmmc' : '') + imgsrc" alt />
    </el-dialog>
  </div>
</template>

<script>
export default {
  props: ["imgsrc", "filedname"],
  data() {
    return {
      loadprogress: [],
      dialogVisible: {},
      form: {},
    };
  },
  methods: {
    handleAvatarSuccess(res, name) {
      this.$bus.$emit("imgUploaded", res, name);
    },
    handleRemove(itemname) {
      this.$bus.$emit("imgRemoved", itemname);
    },
    previewImg(itemname) {
      this.$set(this.dialogVisible, itemname, true);
    },
  },
};
</script>

<style scoped>
/* 图片盒子 */

.imgLoadBox {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  position: relative;
  z-index: 9;
}

/* 图片遮罩 */

.imgBoxmMask {
  top: 0;
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 6px;
}

/* 删除图标 */

.imgLoadBox > i {
  position: absolute;
  color: #fff;
  font-size: 20px;
  top: 50%;
  left: 37.5%;
  transform: translate(-50%, -50%);
  opacity: 0;
}

.imgLoadBox:hover > .imgBoxmMask {
  background-color: rgba(0, 0, 0, 0.5);
  transition: all 0.5s;
}

.imgLoadBox:hover > i {
  opacity: 1;
}

.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}

.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>