<template>
  <main :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
    <div class="wrapper">
      <!-- Sidebar  -->
      <nav id="sidebar" :class="['sidebar', { active: isSidebarActive }]">
        <div class="sidebar-header">
          <nuxt-link to="/">
            <img src="~/assets/new-imgs/foucser/logo.svg" alt="">

          </nuxt-link>
        </div>

        <ul class="mt-4">
          <li>


           <a href="https://calendar.google.com/calendar/" target="_blank">
           <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#s4"></use>
              </svg>
              الخلفيات
            </a>
          </li>
          <li>
            <nuxt-link :to="localePath(`/`)" >
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#s5"></use>
              </svg>
              تقويم جوجل
           </nuxt-link>
          </li>
          <li>
            <nuxt-link :to="localePath(`/`)" >
              <svg class="icon">
                <use xlink:href="~/static/svg/sprite.svg/#s6"></use>
              </svg>
              المؤقت
           </nuxt-link>
          </li>
          <li>
            <nuxt-link :to="localePath(`/`)" >
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#s7"></use>
              </svg>
              الأصوات
           </nuxt-link>
          </li>
          <li>
            <nuxt-link :to="localePath(`/`)" >
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#s8"></use>
              </svg>
              المهام
           </nuxt-link>
          </li>
          <li>
            <nuxt-link :to="localePath(`/`)" >
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#s9"></use>
              </svg>
              الملاحظات
           </nuxt-link>
          </li>
          <li>
            <nuxt-link :to="localePath(`/`)" >
              <svg class="icon">
                <use xlink:href="~/static/svg/sprite.svg/#s10"></use>
              </svg>
              تريللو
           </nuxt-link>
          </li>
        </ul>
      </nav>

      <!-- Page Content  -->
      <div
        id="content"
        class="p-0"
        :class="['content', { 'content-width': isSidebarActive }]"
      >
        <!-- start nav bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-3 bg_nav-cust">
          <div class="container-fluid w-100">
            <!-- trigger for web -->
            <button
              type="button"
              class="btn btn-side ms-3 d-none d-md-none d-lg-block"
              @click="toggleSidebar"
              id="sidebarCollapse"
            >
              <i class="fas fa-bars"></i>
            </button>
            <button
              type="button"
              class="btn btn-side ms-3 d-block d-md-block d-lg-none"

              v-b-toggle.sidebar-1
            >
              <i class="fas fa-bars"></i>
            </button>
            <!-- for web -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <b-navbar-nav class="ms-auto">

                <b-nav-item-dropdown  class="lang">
          <template #button-content>
            <img src="~/assets/new-imgs/foucser/1.svg" alt=""/>
          </template>
          <b-dropdown-item :to="localePath(`/foucs-dashboard/profile-user`)">
             <img src="~/assets/new-imgs/foucser/1.svg" alt=""/> حسابي</b-dropdown-item>
          <b-dropdown-item href="#">  <img src="~/assets/new-imgs/foucser/4.svg" alt=""/> حساب الشركة</b-dropdown-item>

          <b-dropdown-item href="#">  <img src="~/assets/new-imgs/foucser/5.svg" alt=""/> تسجيل خروج</b-dropdown-item>
        </b-nav-item-dropdown>
                <b-nav-item class="lang">
                  <img src="~/assets/new-imgs/foucser/2.svg" alt=""
                /></b-nav-item>
                <b-nav-item class="lang"
                  ><img src="~/assets/new-imgs/foucser/3.svg" alt=""
                /></b-nav-item>

                <b-nav-item href="/" class="lang lan_dash" @click="switchMyLang">
                  {{ $t("front.lang") }}</b-nav-item
                >
              </b-navbar-nav>
            </div>
            <!-- for mobile -->
            <b-sidebar id="sidebar-1"  shadow>
<!-- drop your content -->
           </b-sidebar>
          </div>
        </nav>
        <!-- start main content -->
        <div class="container-fluid w-100">
          <Nuxt />
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: "FoucsOneLayout",
  computed: {
    currentLanguage() {
      return this.$i18n.locale === "ar" ? "English" : "العربية";
    },
  },
  data() {
    return {
      isSidebarActive: false,
    };
  },
  methods: {
    switchMyLang() {
      const locale = this.$i18n.locale == "en" ? "ar" : "en";
      this.$store.commit("localStorage/SET_CURRENT_LOCALE", locale);
      // fetch new locale file
      import(`~/locales/${locale}`).then((module) => {
        // this.$i18n.locale = locale
        // set new messages from new locale file
        this.$i18n.setLocaleMessage(locale, module.default);
        // update url to point to new path, without reloading the page
        window.history.replaceState("", "", this.switchLocalePath(locale));

        // setTimeout(() => {
        this.$nuxt.$router.go();
        // }, 1000);
      });
    },
    toggleSidebar() {
      this.isSidebarActive = !this.isSidebarActive;
    },
  },
  computed: {
    ...mapState({
      currentLocale: (state) => state.localStorage.currentLocale,
    }),
  },
};
</script>

<style></style>
