<template>
  <div class="about_wrapper">
    <div class="container-fluid">
      <div class="row flex_reverse">
        <div class="col-md-7">
          <div class="info_box">
            <span>  {{ $t("front.ab") }}</span>
            <h2> {{ $t("front.ab1") }}</h2>
            <p>
              {{ $t("front.ab2") }}
</p>
            </div>
            <div class="row mt-4">
              <div class="col-md-6">
                <div class="ab">
                  <span>01</span>
                  <h4> {{ $t("front.ab3") }}</h4>
                  <p>مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="ab">
                  <span>02</span>
                  <h4> {{ $t("front.ab4") }}</h4>
                  <p>مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة</p>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-5">
          <div class="img-box d-flex justify-content-lg-end justify-content-center mb-lg-0 mb-4">
            <img src="~/assets/new-imgs/landing/about-man.png" alt="">
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
