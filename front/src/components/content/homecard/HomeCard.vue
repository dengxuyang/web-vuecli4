<template>
  <div
    :style="{
      background:
        'linear-gradient(to right, ' + colorleft + ', ' + colorright + ')',
    }"
    class="card"
  >
    <div class="left">
      <div
        :style="{ backgroundImage: 'url(' + img + ')' }"
        class="card_icon"
      ></div>
    </div>
    <div class="right">
      <div>{{info.number}}</div>
      <div>{{info.text}}</div>
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
export default {
  props: ["colorleft", "colorright", "colorreflection", "icon","info"],
  data() {
    return {
      img: require("@assets/images/" + this.icon + ".png"),
    };
  },
  mounted() {
    // this.img = require("@assets/images/" + this.icon + ".png");
  },
};
</script>

<style lang="scss" scoped>
.card {
  //   background: linear-gradient(to right, #64f6b7, #177d1c);
  height: 150px;
  border-radius: 8px;
  text-align: center;
  color: #ffffff;
  position: relative;
  .card_reflection {
    // background: linear-gradient(#c7f3d7, #ffffff);
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
    //background-image: url("~@assets/images/icon_vip.png");
    background-repeat: no-repeat;
    background-position: center;
  }
}
</style>