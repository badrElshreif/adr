<template>
  <div class="landing_wrapper">
    <Hero></Hero>
    <About></About>
    <WhyUs></WhyUs>
    <Services></Services>
    <Video></Video>
    <Contact></Contact>
    <FreeTry></FreeTry>

    <Partners></Partners>

  </div>
</template>

<script>
import Hero from "~/components/landing/Hero.vue";
import About from "~/components/landing/About.vue";
import WhyUs from "~/components/landing/WhyUs.vue";
import Services from "~/components/landing/Services.vue";
import Video from "~/components/landing/Video.vue";
import Contact from "~/components/landing/Contact.vue";
import FreeTry from "~/components/landing/FreeTry.vue";

import Partners from "~/components/landing/Partners.vue";

  export default {
    name:'landPage',
    layout: "website",
    components:{
      Hero,
      About,
      WhyUs,
      Services,
      Video,
      Contact,
      FreeTry,
      Partners
    }

  }
</script>

<style lang="scss" scoped>

</style>
