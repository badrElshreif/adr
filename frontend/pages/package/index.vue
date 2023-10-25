<template>
  <div class="landing_wrapper">
    <Pack></Pack>
    <FreeTry></FreeTry>

    <Partners class="mb-5"></Partners>

  </div>
</template>

<script>
import Pack from "~/components/landing/Pack.vue";
import FreeTry from "~/components/landing/FreeTry.vue";

import Partners from "~/components/landing/Partners.vue";

  export default {
    layout: "website",
    components:{
      Pack,
      FreeTry,

      Partners


    }
  }
</script>

<style lang="scss" scoped>

</style>
