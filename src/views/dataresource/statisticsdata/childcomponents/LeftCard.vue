<template>
  <div class="leftcard" :style="{ 'background-color': color }">
    <slot><p>插槽默认值</p></slot>
  </div>
</template>

<script>
export default {
  props: ["color"],
};
</script>

<style scoped>
.leftcard {
  width: 274px;
  height: 147px;
  border-radius: 5px;
}
.slotcontainer {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 147px;
  flex-flow: column;
  
  /* line-height: 147px; */
}
.icon {
}
.text{
  margin-top: 20px;
}
</style>