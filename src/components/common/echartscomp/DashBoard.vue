<template>
  <div class="dashboardbox">
    <img :src="require('@assets/images/aircrafticon.png')" alt="" srcset="" />
    <div class="text">出行偏好</div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss">
.dashboardbox {
  width: 106px;
  height: 106px;
  border-radius: 50%;
  background: #1e222e url("~@assets/images/dashboardicon.png") no-repeat;
  background-position: 11px 10px;
  margin-left: 50px;
  img {
    margin-left: 30px;
    margin-top: 30px;
  }
  .text {
    text-align: center;
    margin-top: 10px;
    font-family: MicrosoftYaHei;
    font-size: 10px;
    font-weight: normal;
    font-stretch: normal;
    letter-spacing: 1px;
    color: #1171f7;
  }
}
</style>