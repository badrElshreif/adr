<template>
  <main :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
    <AppNavbar></AppNavbar>
    <Nuxt />
    <AppFooter></AppFooter>
  </main>
</template>

<script>
import { mapState } from "vuex";
import AppNavbar from "~/components/landing/AppNavbar.vue";
import AppFooter from "~/components/landing/AppFooter.vue";

export default {
  name: "WebsiteLayout",
  components: { AppNavbar, AppFooter },
  computed: {
    ...mapState({
      currentLocale: (state) => state.localStorage.currentLocale,
    }),
  },
};
</script>

<style>
</style>
