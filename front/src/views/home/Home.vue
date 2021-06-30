<template>
  <div>
    <div class="overall">
      <div class="ovearall_title">一机游整体情况</div>
      <div class="card_container">
        <div>
        
          <home-card
            :colorleft="'#64f6b7'"
            :colorright="'#177d1c'"
            :colorreflection="'#c7f3d7'"
            :icon="'icon_vip'"
            :info="{ number: numO.member, text: '会员数量' }"
          ></home-card>
        </div>
        <div>
          <home-card
            :colorleft="'#43b6ff'"
            :colorright="'#0168ff'"
            :colorreflection="'#c3e6ff'"
            :icon="'icon_message'"
            :info="{ number: numO.comment, text: '评论数量' }"
          ></home-card>
        </div>
        <div>
          <home-card
            :colorleft="'#74f4d7'"
            :colorright="'#03a185'"
            :colorreflection="'#c6f7ec'"
            :icon="'icon_consulting'"
            :info="{ number: numO.consultation, text: '咨询数量' }"
          ></home-card>
        </div>
        <div>
          <home-card
            :colorleft="'#4edbfc'"
            :colorright="'#0298cc'"
            :colorreflection="'#c8f1fb'"
            :icon="'icon_complaints'"
            :info="{ number: numO.complaint_case, text: '投诉数量' }"
          ></home-card>
        </div>
      </div>
    </div>
    <div class="overall">
      <div class="ovearall_title">资源统计</div>
      <div class="card_container">
        <div>
          <home-card
            :colorleft="'#4edbfc'"
            :colorright="'#0298cc'"
            :colorreflection="'#c8f1fb'"
            :icon="'icon_attractions'"
            :info="{ number: numO.play, text: '景点数量' }"
          ></home-card>
        </div>
        <div>
          <home-card
            :colorleft="'#ae95ff'"
            :colorright="'#753ccb'"
            :colorreflection="'#e0d4f9'"
            :icon="'icon_food'"
            :info="{ number: numO.food, text: '美食数量' }"
          ></home-card>
        </div>
        <div>
          <home-card
            :colorleft="'#ead059'"
            :colorright="'#fd8127'"
            :colorreflection="'#fae6be'"
            :icon="'icon_stay'"
            :info="{ number: numO.stay, text: '住宿数量' }"
          ></home-card>
        </div>
        <div>
          <div>
            <home-card
              :colorleft="'#43b6ff'"
              :colorright="'#0168ff'"
              :colorreflection="'#c3e6ff'"
              :icon="'icon_amusement'"
              :info="{ number: numO.amuse, text: '娱乐数量' }"
            ></home-card>
          </div>
        </div>
      </div>
      <div class="card_container">
        <div>
          <home-card
            :colorleft="'#ead059'"
            :colorright="'#fd8127'"
            :colorreflection="'#fae6be'"
            :icon="'icon_shop'"
            :info="{ number: numO.pro_owner, text: '商店数量' }"
          ></home-card>
        </div>
        <div>
          <home-card
            :colorleft="'#74f4d7'"
            :colorright="'#03a185'"
            :colorreflection="'#c6f7ec'"
            :icon="'icon_goods'"
            :info="{ number: numO.commodity, text: '商品数量' }"
          ></home-card>
        </div>
        <div>
          <home-card
            :colorleft="'#43b6ff'"
            :colorright="'#0168ff'"
            :colorreflection="'#c3e6ff'"
            :icon="'icon_line'"
            :info="{ number: numO.travel_line, text: '线路数量' }"
          ></home-card>
        </div>
        <div>
          <home-card
            :colorleft="'#4edbfc'"
            :colorright="'#0298cc'"
            :colorreflection="'#c8f1fb'"
            :icon="'icon_ticket'"
            :info="{ number: numO.ticket, text: '门票数量' }"
          ></home-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { outputplanmodel, activeStatisticsdata } from "@network/basedata.js";
import HomeCard from "@components/content/homecard/HomeCard";
export default {
  data() {
    return {
      numberCodeArr: [
        "member",
        "comment",
        "consultation",
        "complaint_case",
        "play",
        "food",
        "stay",
        "amuse",
        "pro_owner",
        "commodity",
        "travel_line",
        "ticket",
      ],
      numO:{}
    };
  },
  components: {
    HomeCard,
  },
  created() {
    this.getHomeNumberAll();
  },
  methods: {
    getHomeNumber(code) {
      let params = { data: { is_check: 1 }, directory_code: code };
      activeStatisticsdata(params)
        .then((result) => {
         // this.numO[code]=result.data.list[0].countNums
          this.$set(this.numO,code,result.data.list[0].countNums)
          
        })
        .catch((err) => {});
    },
    getHomeNumberAll() {
      let t = 0;
      for (const item of this.numberCodeArr) {
        t++;
        setTimeout(() => {
          this.getHomeNumber(item);
        }, 10 * t);
      }
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