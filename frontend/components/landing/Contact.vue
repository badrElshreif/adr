<template>
  <div class="contact_wrappe">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="con_info">
            <h2> {{ $t("front.trust") }}</h2>
            <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.</p>
            <ul>
              <li>
                <div class="d-flex align-items-center">
                  <img src="~/assets/new-imgs/landing/c1.svg" alt="">
                  <div class="con_list">
                    <p> {{ $t("front.contact") }}</p>
                    <nuxt-link to="/">+966 53256 4566</nuxt-link>
                  </div>
              </div>
            </li>
            <li>
                <div class="d-flex align-items-center">
                  <img src="~/assets/new-imgs/landing/c2.svg" alt="">
                  <div class="con_list">
                    <p> {{ $t("front.email") }}</p>
                    <nuxt-link to="/">example@mail.com</nuxt-link>
                  </div>
              </div>
            </li>
            <li>
                <div class="d-flex align-items-center">
                  <img src="~/assets/new-imgs/landing/c1.svg" alt="">
                  <div class="con_list">
                    <p> {{ $t("front.whatsapp") }}</p>
                    <nuxt-link to="/"><span>+966 53256 4566</span></nuxt-link>
                  </div>
              </div>
            </li>


            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="img-box">
            <GmapMap :center="center" :zoom="zoom">
      <!-- Add other map components/overlays here -->
    </GmapMap>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>


  export default {
    data() {
    return {
      center: { lat: 23.8859, lng: 45.0792 }, // Saudi Arabia coordinates
      zoom: 6, // Initial zoom level
    }
  },
  }
</script>

<style lang="scss" scoped>

</style>
