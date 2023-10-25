import AdminService from '@/pages/dashboard/admins/-service/-AdminService'
import { mapState, mapGetters } from 'vuex'

export default {
  props: {
    countries: {
      required: true,
    },
  },
    data () {
      return {
        modalId  : 'adminFilterModal',
        titlePage: this.$t('admin.filter'),
        form     : {
          country_id: null,
          state_id  : null,
          city_id   : null,
        },
        queryParam: '',
        customEvents: [
          //{ eventName: 'open-admin-filter-modal', callback: this.showModal },
          //{ eventName: 'close-admin-filter-modal', callback: this.hideModal }
        ]
      }
    },
    async fetch() {
      this.loadData();
    },
    fetchOnServer: true,
    created () {
      this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$on(customEvent.eventName, customEvent.callback)
      }.bind(this));

    },
    destroyed () {
      this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$off(customEvent.eventName, customEvent.callback)
      }.bind(this))
    },
    watch: {
      'form.country_id': function (selected) {
        if (selected) {
          this.fetchStates(selected);
          this.form.state_id   = '';
          this.form.city_id    = '';
        } else {
          this.$EventBus.$emit('admin-filter-event', '');
        }
      },
      'form.state_id': function (selected) {
        if (selected) {
          this.fetchCities(selected);
          this.form.state_id = selected;
          this.form.city_id    = '';
        } else {
          this.$EventBus.$emit('admin-filter-event', '');
        }
      },
      'form.city_id': function (selected) {
        if (selected) {
          this.filterAdmins(selected);
        } else {
          this.$EventBus.$emit('admin-filter-event', '');
        }
      },
    },
    methods: {
      async loadData() {
        const response = await Promise.all([
          await AdminService.getAll(`?is_paginated=1`),
        ])
      },
      async fetchStates(selected) {
        await this.$axios
          .$get(`/admin/location/states?country=${selected.value}`)
          .then((res) => {
            this.$store.commit("locations/SET_STATES", res);
          });
          this.$EventBus.$emit('admin-filter-event', this.axiosParams);
      },
      async fetchCities(selected) {
        await this.$axios
          .$get(`/admin/location/cities?state=${selected.value}`)
          .then((res) => {
            this.$store.commit("locations/SET_CITIES", res);
          });
          this.$EventBus.$emit('admin-filter-event', this.axiosParams);
      },
      async filterAdmins(city) {
        this.form.city_id = city;
        this.$EventBus.$emit('admin-filter-event', this.axiosParams);
      },
    },
    computed: {
        titleStack () {
          return ['']
        },
        ...mapState({
          currentLocale: state => state.localStorage.currentLocale,
        }),
        ...mapGetters({
          states: ["locations/get_states"],
          cities: ["locations/get_cities"],
        }),
        axiosParams() {
          const params = new URLSearchParams();
          this.form.country_id ? params.append('country_id', this.form.country_id.value) : '';
          this.form.state_id ? params.append('state_id', this.form.state_id.value) : '';
          this.form.city_id ? params.append('city_id', this.form.city_id.value) : '';
          return params;
      }
    },

  }
