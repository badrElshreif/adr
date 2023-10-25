import {
  mapState,
  mapGetters
} from 'vuex'

export default {
  data() {
    return {
      countries: [],
      form: {
        country_id: null,
      },
    }
  },
  mounted() {
    let list = [];
      this.$axios.$get('/admin/location/countries?is_paginated=0&is_settings=1&all=1').then((res) => {
        res.forEach((elem) => {
          list.push({
            name        : elem.name,
            value       : elem.id,
            country_code: elem.phone_code,
          });
        });
      });
      this.countries = list;
  },
  methods: {
    async submit() {
      this.submitted = true;
      const validData = await this.$validator.validateAll();
      if (validData) {
        this.create();
      } else {
        this.submitted = false;
      }
    },
    async create() {
      await this.$axios.$post('/admin/settings/generate/country', this.form)
        .then(() => {
          this.back();
          this.$toast.success(this.$t("admin.added_successfully"));
        })
        .catch(() => {
          this.submitted = false;
        });
    },
    back () {
      this.$router.push(this.localePath({ name: "dashboard-settings" }))
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    }),
  },

}
