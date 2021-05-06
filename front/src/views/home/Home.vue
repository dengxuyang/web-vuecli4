<template>
  <div>
    <div class="overall">
      <div class="ovearall_title">一机游整体情况</div>
      <div>
        <el-row :gutter="20">
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>会员数量</div>
              <div>
                <!-- <el-button
                  type="primary"
                  size="default"
                  @click="outputplanmodel"
                  >导出测试</el-button 
                >-->
              </div>
            </div>
          </el-col>
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>评论数量</div>
            </div>
          </el-col>
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>咨询数量</div>
            </div>
          </el-col>
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>投诉数量</div>
            </div>
          </el-col>
        </el-row>
      </div>
    </div>
    <div class="overall">
      <div class="ovearall_title">资源统计</div>
      <div>
        <el-row :gutter="20">
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>会员数量</div>
              <div>1212</div>
            </div>
          </el-col>
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>评论数量</div>
            </div>
          </el-col>
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>咨询数量</div>
            </div>
          </el-col>
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>投诉数量</div>
            </div>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>会员数量</div>
              <div>1212</div>
            </div>
          </el-col>
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>评论数量</div>
            </div>
          </el-col>
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>咨询数量</div>
            </div>
          </el-col>
          <el-col :span="6" :offset="0">
            <div class="card">
              <div>投诉数量</div>
            </div>
          </el-col>
        </el-row>
      </div>
    </div>
  </div>
</template>

<script>
import { outputplanmodel } from "@network/basedata.js";
export default {
  methods: {
    outputplanmodel() {
      let params = {
        data: {},
        directory_code: "play",
        pageNo: 1,
        pageNum: 10,
      
      };
      outputplanmodel(params)
        .then((res) => {
          const link = document.createElement("a");
          let blob = new Blob([res], { type: "application/vnd.ms-excel" });
          link.style.display = "none";
          link.href = URL.createObjectURL(blob);
        //  link.download = res.headers["content-disposition"];
          link.download = "测试"; //下载的文件名
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        })
        .catch((err) => {});
    },
  },
};
</script>

<style scoped>
.el-row {
  margin-bottom: 20px;
}
.overall {
  background-color: #fff;
  border-radius: 5px;

  margin-top: 20px;
  border: 1px solid #f0eeee;
  box-shadow: 0px 0px 10px #d8d5d5;
  padding: 10px;
}
.ovearall_title {
  margin-bottom: 10px;
}
.card {
  background-color: #a29bfe;
  height: 200px;
  border-radius: 5px;
  text-align: center;
  padding-top: 50px;
  color: #ffffff;
}
</style>