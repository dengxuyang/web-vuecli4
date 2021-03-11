<template>
  <div class="topcard" :style="{ 'background-color': color }">
    <slot><p>插槽默认值</p></slot>
  </div>
</template>

<script>
export default {
  props: ["color"],
};
</script>

<style scoped>
.topcard {
  width: 274px;
  height: 109px;
  margin-right: 20px;
  border-radius: 5px;
}
.slotcontainer {
  text-align: center;
  line-height: 109px;
}
.icon{
  width: 35px;
  height: 35px;
  line-height: 25px;
  vertical-align: middle;
  margin-right:10px ;
}

</style>