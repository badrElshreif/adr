<template>
  <div class="partner_wrapp">
    <div class="container-fluid">
      <div class="row d-flex align-items-center">
        <div class="col-lg-4">
          <div class="info-box">
            <h2>{{ $t("front.trust") }}</h2>
<p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل </p>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="part_slider">

            <VueSlickCarousel  v-bind="settings">
              <div class="slid_box" v-for="item in 20" :key="item">
                <img  src="~/assets/new-imgs/landing/part.png" alt="">

              </div>

    </VueSlickCarousel>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import VueSlickCarousel from 'vue-slick-carousel'
  import 'vue-slick-carousel/dist/vue-slick-carousel.css'
  // optional style for arrows & dots
  import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
  export default {
    components: { VueSlickCarousel },
    data() {
      return {
        settings: {
          "dots": true,
  "infinite": true,
  "arrows":false,
  "speed": 500,
  "autoplay":true,
  "slidesToShow":5,
  "slidesToScroll":5,
  "initialSlide": 0,
  "responsive": [
    {
      "breakpoint": 1024,
      "settings": {
        "slidesToShow": 4,
        "slidesToScroll": 3,
        "infinite": true,
        "dots": false
      }
    },
    {
      "breakpoint": 600,
      "settings": {
        "slidesToShow": 2,
        "slidesToScroll": 2,
        "initialSlide": 2,
        "dots": false,
        "infinite": true,


      }
    },
    {
      "breakpoint": 480,
      "settings": {
        "slidesToShow": 2,
        "slidesToScroll": 2,
        "dots": false,
        "infinite": true,


      }
    }
  ]
        },
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>
