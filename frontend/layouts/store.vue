<template>
  <div class="page" :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
    <!-- sidebar Component-->
    <StoreSidebar />

    <!-- Pages Content -->
    <div class="content-wrap">
      <StoreUpperbar />
      <transition name="slide-fade">
        <Nuxt />
      </transition>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import Mixsing from "~/mixins/mixins";
Vue.mixin(Mixsing);
import { mapState } from "vuex";
import StoreSidebar from "~/components/global/store/Sidebar";
import StoreUpperbar from "~/components/global/store/Upperbar";

export default {
  middleware: ["store"],
  mounted() {},
  components: {
    StoreUpperbar,
    StoreSidebar,
  },
  computed: {
    ...mapState({
      currentLocale: (state) => state.localStorage.currentLocale,
    }),
  },
};
</script>

<style lang="scss">
.page {
  display: flex;
  min-height: 100vh;
  &[dir="ltr"] {
    font-family: "Poppins", sans-serif;
  }
}
.content-wrap {
  position: relative;
  min-width: calc(100% - 17%); /* 17% ---> sidebarWidth */
  will-change: width;
  min-height: 100%;
  @media (max-width: 1600px) {
    min-width: calc(100% - 20%);
  }
  @media (max-width: 991px) {
    min-width: 100%;
    width: 100%;
    margin-top: 75px;
  }
}
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
