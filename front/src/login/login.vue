<template>
  <div></div>
</template>

<script>
import { getLoginPage } from "./conf/commonFunc";
export default {
  data() {
    return {};
  },
  methods: {
    getLoginPage() {
      getLoginPage();
    },
  },
  created() {
    this.getLoginPage();
  },
};
</script>

<style>
</style>