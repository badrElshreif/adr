<template>
  <main :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
    <div class="wrapper">
      <!-- Sidebar  -->
      <nav id="sidebar" :class="['sidebar', { active: isSidebarActive }]">
        <div class="sidebar-header">
          <nuxt-link :to="localePath(`/company-dashboard`)">
            <img src="~/assets/new-imgs/foucser/logo.svg" alt="" />
          </nuxt-link>
        </div>

        <ul class="mt-4">

          <li>
            <nuxt-link :to="localePath(`/company-dashboard`)" class="active">
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#home1"></use>
              </svg>
              الرئيسية
              </nuxt-link
            >
          </li>

          <li>
            <nuxt-link :to="localePath(`/company-dashboard/company-office`)" class="active">
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#y1"></use>
              </svg>
              مكاتب الشركة
              </nuxt-link
            >
          </li>
          <div>
  <b-button v-b-toggle.collapse-1 class="bg-transparent border-0 btn_side">  <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#y2"></use>
              </svg>
              الصلاحيات والأدوار</b-button>
  <b-collapse id="collapse-1" class="mt-2">
    <li>
      <nuxt-link :to="localePath(`/company-dashboard/admin`)" class="active">

              المسؤولين

              </nuxt-link
            >


          </li>
          <li>
            <nuxt-link :to="localePath(`/company-dashboard/roles`)" class="active">

              الصلاحيات والأدوار
              </nuxt-link
            >
          </li>
  </b-collapse>
          </div>
          <li>
            <nuxt-link :to="localePath(`/company-dashboard/employees`)" class="active">
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#y3"></use>
              </svg>
              الموظفين
              </nuxt-link
            >
          </li>
          <li>
            <nuxt-link :to="localePath(`/company-dashboard/library`)" class="active">
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#y4"></use>
              </svg>
              المكتبة
              </nuxt-link
            >
          </li>
          <li>
            <nuxt-link :to="localePath(`/company-dashboard/calender`)" class="active">
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#s5"></use>
              </svg>
              التقويم
              </nuxt-link
            >
          </li>
          <li>
            <nuxt-link :to="localePath(`/company-dashboard/reports`)" class="active">
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#y6"></use>
              </svg>
              التقارير
              </nuxt-link
            >
          </li>
          <li>
            <nuxt-link :to="localePath(`/company-dashboard/packeges`)" class="active">
              <svg class="icon icon_strok">
                <use xlink:href="~/static/svg/sprite.svg/#s3"></use>
              </svg>
              الباقات
              </nuxt-link
            >
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
        <nav
          class="navbar navbar-expand-lg navbar-light bg-light px-3 bg_nav-cust"
        >
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
              <div class="ms-auto">
                <div class="d-flex timer_box">
                  <h5>{{ seconds }} ثوانى  </h5>
                  <span>:</span>
                  <h5>{{ minutes }} دقيقة  </h5>
                  <span>:</span>
                  <h5>{{ hours }} ساعة </h5>
                  <span>:</span>
                  <h5> {{ days }} يوم</h5>

                   <!-- , seconds {{ seconds }} -->

                  </div>

              </div>
              <b-navbar-nav class="">
                <b-nav-item-dropdown class="lang">
                  <template #button-content>
                    <img src="~/assets/new-imgs/foucser/1.svg" alt="" />
                  </template>
                  <b-dropdown-item :to="localePath(`/company-dashboard/profile`)">
                    <img src="~/assets/new-imgs/foucser/1.svg" alt="" />
                    حسابي</b-dropdown-item
                  >
                  <b-dropdown-item href="#">
                    <img src="~/assets/new-imgs/foucser/4.svg" alt="" /> حساب
                    الشركة</b-dropdown-item
                  >

                  <b-dropdown-item @click="logout()">
                    <img  src="~/assets/new-imgs/foucser/5.svg" alt="" /> تسجيل
                    خروج</b-dropdown-item
                  >
                </b-nav-item-dropdown>
                <b-nav-item-dropdown class="lang notif_box">
                  <template #button-content>
                    <img src="~/assets/new-imgs/foucser/2.svg" alt="" />
                  </template>
                  <div class=" px-2 notif_card">

                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h5>الاشعارات</h5>
                    <button class="btn btn_link">
                      <img src="~/assets/new-imgs/company/read.svg" alt="" />

                      تحديد الجميع كمقروء
                    </button>
                </div>
                <div class="notif border rounded p-2 mb-3" v-for="notif in 4" :key="notif">
                  <span class="notif_span"></span>
                  <div class="notif_info">
                    <h6>عنوان الإشعار</h6>
                    <p>كان ورم اوبسم هو الدمية القياسية في الصناعة</p>
                    <span class="notif_time">12:23 am</span>
                  </div>
                </div>
                <div class="d-flex  justify-content-center">
                  <nuxt-link  :to="localePath(`/company-dashboard/notifcation`)" class="btn btn_link">

                    شاهد كل الإشعارات
                    </nuxt-link>
                </div>
                  </div>

                </b-nav-item-dropdown>
                <!-- <b-nav-item class="lang">
                  <img src="~/assets/new-imgs/foucser/2.svg" alt=""
                /></b-nav-item> -->
                <b-nav-item class="lang"
                  ><img src="~/assets/new-imgs/foucser/3.svg" alt=""
                /></b-nav-item>

                <b-nav-item
                  href="/"
                  class="lang lan_dash"
                  @click="switchMyLang"
                >
                  {{ $t("front.lang") }}</b-nav-item
                >
              </b-navbar-nav>
            </div>
            <!-- for mobile -->
            <b-sidebar id="sidebar-1" shadow>
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
import AuthService from "~/pages/auth/service/AuthService.js";

export default {
  name: "FoucsOneLayout",
  middleware: ["company"],
  computed: {
    currentLanguage() {
      return this.$i18n.locale === "ar" ? "English" : "العربية";
    },
  },
  data() {
    return {
      isSidebarActive: false,
      startTime: null,
      days: 0,
      hours: 0,
      minutes: 0,
      seconds: 0,
      timerInterval: null
    };
  },
  mounted() {
    this.startTimer();
  },
  beforeDestroy() {
    this.stopTimer();
  },
  methods: {
    async logout() {
      this.$nuxt.$loading.start();
      await AuthService.logout({ device_token: this.firebaseToken })
        .then((res) => {
          this.$store.commit("localStorage/RESET_COMPANY");
          this.$router.replace(this.localePath("/"));
          this.$toast.success(this.$t("admin.logged_out_successfully"));
        })
        .catch(() => {});
      this.$nuxt.$loading.finish();
    },
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
    startTimer() {
      this.startTime = new Date().getTime(); // Set the start time to the current time

      this.updateTimer(); // Update the timer immediately

      this.timerInterval = setInterval(() => {
        this.updateTimer();
      }, 1000);
    },
    stopTimer() {
      clearInterval(this.timerInterval);
    },
    updateTimer() {
      const now = new Date().getTime();
      const elapsed = now - this.startTime;

      this.days = Math.floor(elapsed / (1000 * 60 * 60 * 24));
      this.hours = Math.floor((elapsed % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      this.minutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
      this.seconds = Math.floor((elapsed % (1000 * 60)) / 1000);
    }
  },
  computed: {
    ...mapState({
      currentLocale: (state) => state.localStorage.currentLocale,
    }),
  },
};
</script>

<style scoped lang="scss">

#sidebar{
  background: var(--Primary, #DF3C14);
box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.04);
}
.navbar-light {
  background:  #FFF7F5 !important;
box-shadow: 0px 1px 10px 0px rgba(0, 0, 0, 0.05);
}
.timer_box{
  h5{
    border-radius: 4px;
border: 1px solid #DF3C14;
padding: 10px;
color: #DF3C14;
font-size: 14px;
font-style: normal;
font-weight: 600;
  }
  span{
    padding: 5px 10px;
color: #DF3C14;
font-size: 14px;
font-style: normal;
font-weight: 600;

  }

}
#sidebar ul li:hover a{
  color: #DF3C14;
}
#sidebar ul li:hover  svg.icon{
  fill: none;
  transition: all ease 0.2s;
  // stroke: #7477FF;

}
#sidebar ul li:hover  svg.icon.icon_strok{
  stroke: #DF3C14;
}
#sidebar ul li:hover {
    background-color: #fff;
}
.btn_side{
  color: #fff !important ;
  background: url(../assets/new-imgs/company/arrow.png) no-repeat -10px ;
  transition: all ease 0.2s;
    margin-inline: 20px;
    display: flex;
    align-items: center;
    padding: 10px;
    margin-bottom: 1rem;
    width: 85%;
    background-size: 25px;
    background-position: -5px 10px;
    border-radius: 0;
    transition: all ease 0.2s;


}
.btn_side:focus{
  box-shadow: unset !important;
  color: #DF3C14 !important;
  background-color: #fff !important;
  transition: all ease 0.2s;

}
.btn_side:hover{
  box-shadow: unset !important;
  color: #DF3C14 !important;
  background-color: #fff !important;
  transition: all ease 0.2s;


}

 svg.icon.icon_strok {
    stroke: #fff;
    fill: none;
    width: 24px;
    height: 24px;
    margin-inline-end: 10px;
    transition: all ease 0.2s;

}
.btn_side:focus  svg.icon.icon_strok{
  stroke: #DF3C14 !important;
  transition: all ease 0.2s;

}
.btn_side:hover  svg.icon.icon_strok{
  stroke: #DF3C14 !important;
  transition: all ease 0.2s;

}
</style>
