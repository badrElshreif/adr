<template>
  <div class="page" :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
    <!-- sidebar Component-->
    <Sidebar />

    <!-- Pages Content -->
    <div class="content-wrap">
      <Upperbar />
      <!--  if page name != countries -->
      <filterModal :countries="countries" v-if="
      !$route.path.includes('locations') &&
      !$route.path.includes('roles') &&
      !$route.path.includes('bank-accounts') &&
      !$route.path.includes('payment-methods') &&
      !$route.path.includes('home-slider') &&
      !$route.path.includes('home-content') &&
      !$route.path.includes('content') &&
      !$route.path.includes('zones') &&
      !$route.path.includes('zones-prices') &&
      !$route.path.includes('national-zones') &&
      !$route.path.includes('national-zones-prices') &&
      !$route.path.includes('notification/recieved') &&
      !$route.path.includes('contact') &&
      !$route.path.includes('create') &&
      !$route.path.includes('edit') &&
      !$route.path.includes('settings')

      "/>
      <div class="level">
        <div :class="$i18n.locale == 'en' ? 'level-left' : 'level-right'">
          <span>{{ $t("admin.welcome") }} </span>
        </div>
        <div :class="$i18n.locale == 'en' ? 'level-right' : 'level-left'">
          <span> </span> <span> {{ date }} </span>
        </div>
      </div>
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
  import {
    mapState,
    mapGetters
  } from "vuex";
  import Upperbar from "~/components/global/Upperbar.vue";
  import Sidebar from "~/components/global/Sidebar.vue";
  import filterModal from './-filter/-index.vue';
  import moment from "moment";

  export default {
    middleware: ["auth", "admin"],
    components: {
      Sidebar,
      Upperbar,
      filterModal
    },
    data() {
      return {
        date: moment().locale(this.$i18n.locale).format("LL"),
        countries: [],
      }
    },
    mounted() {
      // let list = [];
      // this.$axios.$get('/admin/location/countries?is_paginated=0&all=1').then((res) => {
      //   res.forEach((elem) => {
      //     list.push({
      //       name        : elem.name,
      //       value       : elem.id,
      //       country_code: elem.phone_code,
      //     });
      //   });
      // });
      // this.countries = list;
    },
    computed: {
      ...mapState({
        currentLocale: (state) => state.localStorage.currentLocale,
      }),
      // ...mapGetters({
      //   states: ["locations/get_states"],
      //   cities: ["locations/get_cities"],
      // }),
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
    min-width: calc(100% - 17%);
    /* 17% ---> sidebarWidth */
    will-change: width;
    min-height: 100%;
    background-color: #eee;
    padding: 15px 25px;

    // @media (max-width: 1600px) {
    //   min-width: calc(100% - 25%);
    // }

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

  .slide-fade-enter,
  .slide-fade-leave-to

  /* .slide-fade-leave-active below version 2.1.8 */
    {
    transform: translateX(10px);
    opacity: 0;
  }

</style>
