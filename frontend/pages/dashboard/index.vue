<template>
  <div class="home-page">
    <div class="Statistecs" v-if="statistics" v-show="permissions.includes('statistics.index')">
      <b-row>
        <nuxt-link :to="{
                path: localePath(`/dashboard/current-companies`),
                //query: { type: 'companies', is_active: 'true',  country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
              }" class="col-lg-3">

          <div class="users">
            <div class="icon_wrapper">
              <svg class="icon">
                <use xlink:href="~/static/svg/sprite.svg#users"></use>
              </svg>
            </div>
            <div class="users-statistics">
              <p>{{ statistics["companies"] }}</p>
            </div>
            <p class="title">{{ $t("admin.companies") }}</p>
          </div>
          <!-- End users Box -->
        </nuxt-link>
        <nuxt-link :to="{
                path: localePath(`/dashboard/current-companies`),
                //query: { type: 'companies', is_active: 'true',  country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
              }" class="col-lg-3">
          <div class="users">
            <div class="icon_wrapper">
              <svg class="icon">
                <use xlink:href="~/static/svg/sprite.svg#users"></use>
              </svg>
            </div>
            <div class="employees-statistics">
              <p>{{ statistics["employees"] }}</p>
            </div>
            <p class="title">{{ $t("admin.employees") }}</p>
          </div>
        </nuxt-link>
        <nuxt-link :to="{
                path: localePath(`/dashboard/companies`),
                query: { type: 'companies', is_active: 'true'},
              }" class="col-lg-3">
          <div class="users">
            <div class="icon_wrapper">
              <svg class="icon">
                <use xlink:href="~/static/svg/sprite.svg#users"></use>
              </svg>
            </div>
            <div class="focus-statistics">
              <p>{{ statistics["focus"] }}</p>
            </div>
            <p class="title">{{ $t("admin.focus_accounts") }}</p>
          </div>
        </nuxt-link>
            <nuxt-link :to="{
                path: localePath(`/dashboard/rooms`),
                query: { type: 'focus', is_active: 'true'},
              }" class="col-lg-3">
          <div class="users">
            <div class="icon_wrapper">
              <svg class="icon">
                <use xlink:href="~/static/svg/sprite.svg#users"></use>
              </svg>
            </div>
            <div class="focus-statistics">
              <p>{{ statistics["focus_room"] }}</p>
            </div>
            <p class="title">{{ $t("admin.focus_rooms") }}</p>
          </div>
        </nuxt-link>

      </b-row>
    </div>
  </div>
</template>
<script>
  import {
    mapState,
    mapGetters
  } from "vuex";
  import moment from "moment";
  export default {
    data() {
      return {
        date: moment().locale(this.$i18n.locale).format("LL"),
        loading: true,
        Id: "",
        singleBill: "",
        admins: "",
        users: "",
        blockUsers: "",
        activeSubs: "",
        inActiveSubs: "",
        canceledSubsc: "",
        newSubsc: "",
        newSupport: "",
        pendingSupport: "",
        doneSupport: "",
        country_id: null,
        statistics: [],
        locationParam: '',
        permissions: this.$cookies.get("permissions"),
      };
    },
    watch: {
      async $route(to) {
        this.updateLocationParams(to);
        await this.fetchStatistics(this.locationParam);

      },
    },
    computed: {
      ...mapState({
        currentLocale: (state) => state.localStorage.currentLocale,
        mokayiefyData: (state) => JSON.parse(state.localStorage.mokayiefyData),
        mokayiefyPermissions: (state) => JSON.parse(state.localStorage.mokayiefyPermissions),
      }),
      ...mapGetters({
        //  countries: ["locations/get_countries"],
      })
    },
    async asyncData(context) {
      // await context.$axios.$get(`/location/countries`).then((res) => {
      //   context.store.commit("locations/SET_COUNTRIES", res);
      // });
      const [statistics] = await Promise.all([
        context.$axios.$get(`/admin/statistics`).catch(() => {}),
      ]);
      return {
        statistics
      };
    },
    mounted() {
      this.updateLocationParams(this.$route);
      this.fetchStatistics(this.locationParam);
      if (this.$route.query.country_id) {
        this.country_id = this.$route.query.country_id;
      }
    },
    methods: {
      updateLocationParams(route) {
        this.locationParam =
          `?country_id=${route.query.country_id || ''}&state_id=${route.query.state_id || ''}&city_id=${route.query.city_id || ''}`;
      },
      fetchStatistics(select) {
        // this.$axios
        //   .$get(`/admin/statistics${select}`)
        //   .then((res) => {
        //     this.statistics = res;
        //   });
      }
    },
  };

</script>

<style scoped>
  @import "~/assets/css/pages/homePage.css";

</style>
