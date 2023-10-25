<template>
  <div class="hero_wrapper">
    <div class="container-fluid">
      <div class="row flex_reverse">
        <div class="col-md-6 d-lg-flex align-items-center">
          <div class="info_box">
              <h1> {{ $t("front.hero") }}</h1>
            <h1 class="red">  {{ $t("front.hero1") }}</h1>
            <p> {{ $t("front.hero3") }} <span> {{ $t("front.hero4") }}</span> {{ $t("front.hero5") }} </p>
            <nuxt-link :to="localePath(`/auth`)">
               {{ $t("front.free") }}
            </nuxt-link>
            </div>
        </div>
        <div class="col-md-6">
          <div class="img-box d-flex justify-content-lg-end justify-content-center mb-lg-0 mb-4">
            <img src="~/assets/new-imgs/landing/man.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {

  }
</script>

<style lang="scss" scoped>

</style>
