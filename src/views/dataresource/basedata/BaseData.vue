<template>
  <div>
    <div class="tabbar">
      <main-tab-bar :tabitem="tabItem">
        <div slot="酒店">
          <div class="select">
            <div class="selectitem">当前酒店总数：<span>268</span>家</div>
            <div class="selectitem">其中5星：<span>10</span>家</div>
            <div class="selectitem">4星：<span>3</span>家</div>
            <div class="selectitem">3星：<span>180</span>家</div>
            <right-btn :top='"20"' :color="'#2a2d3e'"
              ><img
                :src="require('@assets/images/rightbtniconmap.png')"
                alt=""
              />地图模式</right-btn
            >
          </div>
          <table-comp></table-comp>
        </div>
      </main-tab-bar>
      <right-btn :top='"23"'  :color="'#0c8dd9'">导出数据</right-btn>
    </div>
    <!-- <div class="select">
      <div class="selectitem">当前酒店总数：<span>268</span>家</div>
      <div class="selectitem">其中5星：<span>10</span>家</div>
      <div class="selectitem">4星：<span>3</span>家</div>
      <div class="selectitem">3星：<span>180</span>家</div>
      <right-btn :color='"#2a2d3e"'><img :src='require("@assets/images/rightbtniconmap.png")' alt="">地图模式</right-btn>
    </div>
    <table-comp></table-comp> -->
  </div>
</template>

<script>
import MainTabBar from "@components/content/maintabbar/MainTabBar";
import RightBtn from "@components/content/rightbtn/RightBtn";
import TableComp from "@components/content/tablecomp/TableComp";
export default {
  components: {
    MainTabBar,
    TableComp,
    RightBtn,
  },
  data() {
    return {
      tabItem: [
        {
          label: "酒店",
        },
        {
          label: "餐饮",
        },
        {
          label: "景区",
        },
        {
          label: "购物场所",
        },
        {
          label: "娱乐场所",
        },
        {
          label: "交通出行",
        },
      ],
    };
  },
};
</script>

<style lang='scss' scoped>
.select {
  height: 50px;
  line-height: 50px;
  margin-left: 42px;
  font-family: MicrosoftYaHei;
  font-size: 10px;
  font-weight: normal;
  font-stretch: normal;
  letter-spacing: 1px;
  color: #b5b5b6;
  display: flex;
  position: relative;
  .selectitem {
    margin-right: 15px;
  }
  span {
    color: #f6d602;
  }
  img {
    margin-right: 5px;
    line-height: 50px;
    vertical-align: middle;
    margin-top: -3px;
  }
}
.tabbar {
  position: relative;
}
</style>