<template>
  <div>
    <div>
  <b-navbar toggleable="lg" type="light">
    <div class="container-fluid">
      <b-navbar-brand :to="localePath(`/`)"><img src="~/assets/new-imgs/landing/logo.svg" alt=""></b-navbar-brand>

<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

<b-collapse id="nav-collapse" is-nav >
  <b-navbar-nav class="ms-auto">

    <b-nav-item :to="localePath(`/`)"> {{ $t("front.home") }}</b-nav-item>
    <b-nav-item href="#"> {{ $t("front.about") }}</b-nav-item>
    <b-nav-item :to="localePath(`/package`)"> {{ $t("front.package") }}</b-nav-item>
    <b-nav-item href="#"> {{ $t("front.contact") }}</b-nav-item>
    <b-nav-item  class="btn-1" v-b-modal.modal-10><img src="~/assets/new-imgs/landing/user.svg" alt=""> {{ $t("front.log") }}</b-nav-item>
    <b-nav-item :to="localePath(`/auth`)"  class="btn-2"> {{ $t("front.signup") }}</b-nav-item>
    <b-nav-item href="#" class="lang" @click="switchMyLang"> {{ $t("front.lang") }}</b-nav-item>

  </b-navbar-nav>


</b-collapse>
    </div>
  </b-navbar>
</div>
<login></login>
  </div>
</template>

<script>
import  Login from "~/components/auth/Login.vue";
  export default {
    components:{
      Login
    },
    computed: {
    currentLanguage() {
      return this.$i18n.locale === 'ar' ? 'English' : 'العربية';
    },
  },
    methods: {

      switchMyLang() {
      const locale = this.$i18n.locale == 'en' ? 'ar' : 'en'
      this.$store.commit('localStorage/SET_CURRENT_LOCALE', locale)
      // fetch new locale file
      import(`~/locales/${locale}`).then((module) => {
        // this.$i18n.locale = locale
        // set new messages from new locale file
        this.$i18n.setLocaleMessage(locale, module.default)
        // update url to point to new path, without reloading the page
        window.history.replaceState('', '', this.switchLocalePath(locale))

        // setTimeout(() => {
        this.$nuxt.$router.go()
        // }, 1000);
      })
    },
  },
  }
</script>

<style lang="scss" scoped>

</style>
