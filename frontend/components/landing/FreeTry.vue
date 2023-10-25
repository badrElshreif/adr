<template>
  <div class="free">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="free_box text-center position-relative">
            <div class="clipped-div"></div>

            <div class="text-center">
              <h2>  {{ $t("front.freeTrai") }}<br>
                {{ $t("front.freeTrais") }}</h2>
               <nuxt-link :to="localePath(`/auth`)"> {{ $t("front.free") }}</nuxt-link>
            </div>
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
