<template>
  <div>
    <div class="overall">
      <div class="ovearall_title">一机游整体情况</div>
      <div class="card_container">
        <div>
          <HomeCard
            :colorleft="'#64f6b7'"
            :colorright="'#177d1c'"
            :colorreflection="'#c7f3d7'"
            :icon="'icon_vip'"
            :info="{number:1200,text:'会员数量'}"
          ></HomeCard>
        </div>
        <div>
          <HomeCard
            :colorleft="'#43b6ff'"
            :colorright="'#0168ff'"
            :colorreflection="'#c3e6ff'"
            :icon="'icon_message'"
            :info="{number:856,text:'评论数量'}"
          ></HomeCard>
        </div>
        <div>
          <HomeCard
            :colorleft="'#74f4d7'"
            :colorright="'#03a185'"
            :colorreflection="'#c6f7ec'"
            :icon="'icon_consulting'"
            :info="{number:259,text:'咨询数量'}"
          ></HomeCard>
        </div>
        <div>
          <HomeCard
            :colorleft="'#4edbfc'"
            :colorright="'#0298cc'"
            :colorreflection="'#c8f1fb'"
            :icon="'icon_complaints'"
            :info="{number:19,text:'投诉数量'}"
          ></HomeCard>
        </div>
      </div>
    </div>
    <div class="overall">
      <div class="ovearall_title">资源统计</div>
       <div class="card_container">
         <div>
          <HomeCard
            :colorleft="'#4edbfc'"
            :colorright="'#0298cc'"
            :colorreflection="'#c8f1fb'"
            :icon="'icon_attractions'"
            :info="{number:45,text:'景点数量'}"
          ></HomeCard>
        </div>
        <div>
          <HomeCard
            :colorleft="'#ae95ff'"
            :colorright="'#753ccb'"
            :colorreflection="'#e0d4f9'"
            :icon="'icon_food'"
            :info="{number:99,text:'美食数量'}"
          ></HomeCard>
        </div>
        <div>
          <HomeCard
            :colorleft="'#ead059'"
            :colorright="'#fd8127'"
            :colorreflection="'#fae6be'"
            :icon="'icon_stay'"
            :info="{number:67,text:'住宿数量'}"
          ></HomeCard>
        </div>
        <div>
         <div>
          <HomeCard
            :colorleft="'#43b6ff'"
            :colorright="'#0168ff'"
            :colorreflection="'#c3e6ff'"
            :icon="'icon_amusement'"
            :info="{number:245,text:'娱乐数量'}"
          ></HomeCard>
        </div>
        </div>
      </div>
       <div class="card_container">
        <div>
        <HomeCard
            :colorleft="'#ead059'"
            :colorright="'#fd8127'"
            :colorreflection="'#fae6be'"
            :icon="'icon_shop'"
            :info="{number:36,text:'商店数量'}"
          ></HomeCard>
        </div>
        <div>
         
          <HomeCard
            :colorleft="'#74f4d7'"
            :colorright="'#03a185'"
            :colorreflection="'#c6f7ec'"
            :icon="'icon_goods'"
            :info="{number:3568,text:'商品数量'}"
          ></HomeCard>
        </div>
        <div>
          <HomeCard
            :colorleft="'#43b6ff'"
            :colorright="'#0168ff'"
            :colorreflection="'#c3e6ff'"
            :icon="'icon_line'"
            :info="{number:185,text:'线路数量'}"
          ></HomeCard>
        </div>
        <div>
          <HomeCard
            :colorleft="'#4edbfc'"
            :colorright="'#0298cc'"
            :colorreflection="'#c8f1fb'"
            :icon="'icon_ticket'"
            :info="{number:6500,text:'门票数量'}"
          ></HomeCard>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { outputplanmodel } from "@network/basedata.js";
import HomeCard from "@components/content/homecard/HomeCard";
export default {
  components: {
    HomeCard,
  },
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

<style lang="scss" scoped>
.el-row {
  margin-bottom: 20px;
}
.overall {
  background-color: #fff;
  border-radius: 5px;
  padding-bottom: 30px;
  padding-left: 30px;
  margin-top: 20px;
  border: 1px solid #f0eeee;
  box-shadow: 0px 0px 10px #d8d5d5;
}
.ovearall_title {
  font-family: MicrosoftYaHei-Bold;
  font-size: 16px;
  font-weight: bold;
  font-stretch: normal;
  line-height: 30px;
  letter-spacing: 1px;
  color: #595757;
  padding-top: 30px;
  padding-bottom: 24px;
}
.card_container {
  padding-bottom: 30px;
  display: flex;
  div {
    margin-right: 25px;
    width: 17vw;
  }
}
</style>