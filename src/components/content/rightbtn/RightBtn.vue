<template>
  <div class="rightbtn" :style="{ 'background-color': color,'top': top+'px' }">
    <slot>默认文字</slot>
  </div>
</template>

<script>
export default {
  props: ["color",'top'],
};
</script>

<style scoped>
.rightbtn {
  text-align: center;
  position: absolute;
  cursor: pointer;
  line-height: 30px;
  font-size: 10px;
  top: 20px;
  right: 50px;
  width: 100px;
  height: 30px;
}
</style>