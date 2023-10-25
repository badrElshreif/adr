<template>
  <footer>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 justify-content-center d-flex border_bottom">
          <div class="foot text-center">
            <img src="~/assets/new-imgs/landing/logo-white.svg" alt="" />
            <ul class="d-flex social_foot mt-2">
              <li class="p-2">
                <nuxt-link to="/"
                  ><img src="~/assets/new-imgs/landing/FB.svg" alt=""
                /></nuxt-link>
              </li>
              <li class="p-2">
                <nuxt-link to="/"
                  ><img src="~/assets/new-imgs/landing/Insta.svg" alt=""
                /></nuxt-link>
              </li>
              <li class="p-2">
                <nuxt-link to="/"
                  ><img src="~/assets/new-imgs/landing/Linkedin.svg" alt=""
                /></nuxt-link>
              </li>
              <li class="p-2">
                <nuxt-link to="/"
                  ><img src="~/assets/new-imgs/landing/Twitter.svg" alt=""
                /></nuxt-link>
              </li>
            </ul>
          </div>
        </div>
        <div class="d-md-flex justify-content-md-between text-center col-12">
          <p> {{ $t("front.copyRight") }}</p>
          <ul class="d-flex justify-content-center">
            <li>
              <nuxt-link to="/">  {{ $t("front.terms") }}</nuxt-link>
            </li>
            <li class="dev"> - </li>
            <li><nuxt-link to="/">{{ $t("front.policy") }}</nuxt-link></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
