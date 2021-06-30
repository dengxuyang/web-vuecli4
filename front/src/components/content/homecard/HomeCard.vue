<template>
  <div
    :style="{
      background:
        'linear-gradient(to right, ' + colorleft + ', ' + colorright + ')',
    }"
    class="card"
  >
    <div class="left">
      <div :style="{ backgroundImage: 'url(' + img + ')' }" class="card_icon"></div>
    </div>
    <div class="right">
      <div>
        <!-- {{ !info.number ? 0 : info.number }} -->
        <count-to :startVal="0" :endVal="!info.number ? 0 : info.number" :duration="1000"></count-to>
      </div>
      <div>{{ info.text }}</div>
    </div>
    <div
      class="card_reflection"
      :style="{
        background: 'linear-gradient(' + colorreflection + ', #ffffff)',
      }"
    ></div>
  </div>
</template>

<script>
//count to 插件
import CountTo from "vue-count-to";
export default {
  components: {
    CountTo,
  },
  props: ["colorleft", "colorright", "colorreflection", "icon", "info"],
  watch: {
    // info(val){
    //   this.info.number=val
    //   console.log(val);
    // }
  },
  data() {
    return {
      img: require("@assets/images/" + this.icon + ".png"),
    };
  },

};
</script>

<style lang="scss" scoped>
.card {
  height: 150px;
  border-radius: 8px;
  text-align: center;
  color: #ffffff;
  position: relative;
  .card_reflection {
    height: 30px;
    width: 100%;
    border-radius: 8px;
    position: absolute;
    bottom: -30px;
  }
  .left {
    float: left;
    width: 50%;
    height: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .right {
    width: 50%;
    height: 150px;
    display: flex;
    flex-flow: column;
    justify-content: center;
    padding-right: 10px;
    font-size: 36px;
    div:nth-child(2) {
      font-size: 15px;
    }
  }
  .card_icon {
    width: 60px;
    height: 60px;
    background-color: #ffffff;
    border-radius: 50%;
    background-repeat: no-repeat;
    background-position: center;
  }
}
</style>