<template>
  <div class="container">
    <div class="topcontainer">
      <div class="topitem">
        <span
          ><img :src="require('@assets/images/rlicon.png')" alt="" srcset=""
        /></span>
        <span>您当前购买的服务将于2022年02月01日到期</span>
        <span>2021-02-01至2022-02-01</span>
        <span>我要续费</span>
      </div>
    </div>
    <div class="carditem">
      <!-- 卡片组件 -->
      <div
        v-for="(item, index) in statusData"
        :key="index"
        @click="chageCard(index)"
        class="cardcontainer"
      >
        <top-card :color="item.color">
          <div class="slotcontainer">
            <span class="icon"><img :src="item.icon" alt="" /></span>
            <span class="text">{{ item.text }}</span>
          </div>
        </top-card>
        <i
          v-if="index == isCardActive"
          class="el-icon-caret-top icondirection"
        ></i>
      </div>
    </div>
    <div class="pop">
      <div class="leftcarditem">
        <div
          v-for="(item, index) in statusDetailData"
          :key="index"
          class="popcardcontainer"
        >
          <left-card :color="item.color">
            <div class="slotcontainer">
              <span class="icon"><img :src="item.icon" alt="" /></span>
              <span class="text">{{ item.text }}</span>
            </div>
          </left-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TopCard from "./childcomponents/TopCard";
import LeftCard from "./childcomponents/LeftCard";
export default {
  components: {
    TopCard,
    LeftCard,
  },
  data() {
    return {
      statusData: [
        {
          icon: require("@assets/images/ygmicon.png"),
          text: "已购买",
          color: "#d74d54",
        },
        {
          icon: require("@assets/images/wgmicon.png"),
          text: "未购买",
          color: "#2a2d3e",
        },
      ],
      statusDetailData: [
        {
          icon: require("@assets/images/qyklicon.png"),
          text: "全域客流",
          color: "#00b07d",
        },
        {
          icon: require("@assets/images/jqdcicon.png"),
          text: "景区洞察",
          color: "#46a4e8",
        },
        {
          icon: require("@assets/images/ykhxicon.png"),
          text: "游客画像",
          color: "#22a3ab",
        },
        {
          icon: require("@assets/images/jtydicon.png"),
          text: "交通拥堵",
          color: "#634dde",
        },
        {
          icon: require("@assets/images/kydicon.png"),
          text: "客源地",
          color: "#7bb118",
        },
        {
          icon: require("@assets/images/yqjcicon.png"),
          text: "舆情监测",
          color: "#1d2088",
        },
      ],
      isCardActive: 0,
    };
  },

  methods: {
    chageCard(index) {
      this.isCardActive = index;
    },
  },
};
</script>

<style lang='scss' scoped>
.container {
  position: relative;
}
.cardcontainer {
  position: relative;
}
.topcontainer {
  height: 77px;
  margin-left: 31px;
  border-bottom: solid 1px #7d7d7d;
}
.carditem {
  margin-left: 31px;
  margin-top: 23px;
  display: flex;
}
.pop {
  position: absolute;
  top: 250px;
  left: 0px;
  /* height: 50vh; */
  width: inherit;
  background-color: #333748;
  box-sizing: border-box;
}
.icondirection {
  position: absolute;
  font-size: 32px;
  color: #333748;
  top: 130px;
  left: 50%;
  transform: translateX(-100%);
}
.popcardcontainer {
  margin-right: 21px;
  margin-top: 37px;
}
.leftcarditem {
  padding-top: 8px;
  padding-left: 31px;
  padding-bottom: 45px;
  margin-right: 50px;
  display: flex;
  flex-wrap: wrap;
}
.topitem {
  width: 612px;
  height: 30px;
  line-height: 30px;
  display: inline-block;
  background-color: #2a2d3e;
  margin-top: 30px;
  font-family: MicrosoftYaHei;
  font-size: 12px;
  font-weight: normal;
  font-stretch: normal;
  letter-spacing: 1px;
  span:nth-child(1) {
    margin-left: 10px;
    margin-right: 10px;
  }
  span:nth-child(2) {
    padding-right: 20px;
    border-right: 2px solid #58595c;
  }
  span:nth-child(3) {
    padding-left: 20px;
  }
  span:nth-child(4) {
    background-color: #088ad6;
    height: 100%;
    display: inline-block;
    padding: 0 20px;
    cursor: pointer;
    margin-left: 16px;
  }
  img {
    vertical-align: middle;
    margin-top: -3px;
  }
}
</style>