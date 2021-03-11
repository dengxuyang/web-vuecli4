<template>
  <div>
    <div class="tabbar">
      <main-tab-bar :tabitem="tabItem">
        <div slot="实时客流">
          <div class="select">
            <div class="selectitem">
              选择时间<i class="el-icon-arrow-down"></i>
            </div>
            <div class="selectitem">
              选择景区<i class="el-icon-arrow-down"></i>
            </div>
            <div class="selectitem">今日客流总量</div>
            <right-btn :color="'#2a2d3e'"
              ><img
                :src="require('@assets/images/rightbtnicon.png')"
                alt=""
              />图表模式</right-btn
            >
          </div>
          <table-comp></table-comp>
        </div>
        <div slot="游客画像">
          <div class="select">
            <div class="selectitem">
              选择时间<i class="el-icon-arrow-down"></i>
            </div>
            <div class="selectitem">
              选择景区<i class="el-icon-arrow-down"></i>
            </div>

            <right-btn :color="'#2a2d3e'"
              ><img
                :src="require('@assets/images/rightbtnicon.png')"
                alt=""
              />图表模式</right-btn
            >
          </div>
          <div class="infobar">西湖景区</div>
          <div class="chartbox">
            <div>
              <ring-chart></ring-chart>
            </div>
            <div>
              <cylindrical-chart></cylindrical-chart>
            </div>
            <div>
              <dash-board></dash-board>
            </div>
          </div>
        </div>
      </main-tab-bar>
      <right-btn :top="'23'" :color="'#0c8dd9'">导出数据</right-btn>
    </div>
  </div>
</template>

<script>
import MainTabBar from "@components/content/maintabbar/MainTabBar";
import RightBtn from "@components/content/rightbtn/RightBtn";
import TableComp from "@components/content/tablecomp/TableComp";
import RingChart from "@components/common/echartscomp/RingChart";
import CylindricalChart from "@components/common/echartscomp/CylindricalChart";
import DashBoard from "@components/common/echartscomp/DashBoard";
export default {
  components: {
    MainTabBar,
    TableComp,
    RightBtn,
    RingChart,
    CylindricalChart,
    DashBoard,
  },
  data() {
    return {
      tabItem: [
        {
          label: "实时客流",
        },
        {
          label: "游客画像",
        },
        {
          label: "来源地分析",
        },
        {
          label: "舆情监测",
        },
        {
          label: "游客行为",
        },
        {
          label: "热力图",
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
  position: relative;
  color: #b5b5b6;
  margin-left: 42px;
  font-family: MicrosoftYaHei;
  font-size: 10px;
  font-weight: normal;
  font-stretch: normal;
  letter-spacing: 1px;
  display: flex;
  position: relative;
  .selectitem {
    margin-right: 30px;
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
.infobar {
  height: 36px;
  line-height: 36px;
  padding-left: 42px;
  background-color: #343a4a;
  font-family: MicrosoftYaHei;
  font-size: 12px;
  font-weight: normal;
  font-stretch: normal;
  letter-spacing: 1px;
  color: #ddc109;
}
.chartbox {
  display: flex;
  margin-top: 20px;
}
</style>