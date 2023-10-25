import { mapState, mapGetters } from 'vuex'
import UserService from "../../pages/dashboard/users/-service/-UserService";

export default {
  props: {
    countries: {
      required: true,
    },
  },
    data () {
      return {
        modalId  : 'usersFilterModal',
        titlePage: this.$t('users.filter'),
        form     : {
          country_id: this.$route.query.country_id || null,
          state_id  : this.$route.query.state_id || null,
          city_id   : this.$route.query.city_id || null,
        },
        queryParams : {
          country_id: this.$route.query.country_id || null,
          state_id  : this.$route.query.state_id || null,
          city_id   : this.$route.query.city_id || null,
        },
        customEvents: [
          //{ eventName: 'open-users-filter-modal', callback: this.showModal },
          //{ eventName: 'close-users-filter-modal', callback: this.hideModal }
        ]
      }
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
          this.fetchStates(selected.value);
          this.queryParams.country_id = selected.value;
          this.ChangeRouter()
        } else {
          this.queryParams.country_id = '';
          this.ChangeRouter()
        }
      },
      'form.state_id': function (selected) {
        if (selected) {
          this.fetchCities(selected);
          this.queryParams.state_id = selected.value;
          this.ChangeRouter()
        } else {
          this.queryParams.state_id = '';
          this.ChangeRouter()
        }
      },
      'form.city_id': function (selected) {
        if (selected) {
          this.queryParams.city_id = selected.value;
          this.ChangeRouter()
        } else {
          this.queryParams.city_id = '';
          this.ChangeRouter()
        }
      },
    },
    mounted() {
      if(this.$route.query.country_id) {
        this.fetchStates(this.$route.query.country_id);
      }
    },
    methods: {
      resetFilter () {
        this.queryParams = {
          country_id: null,
          state_id  : null,
          city_id   : null,
        };
        this.form = {
          country_id: null,
          state_id  : null,
          city_id   : null,
        };
        this.$router.push({ query: null });
      },
      ChangeRouter() {
        this.$router.push({ query: this.queryParams });
      },
      async fetchStates(selected) {
        await this.$axios
          .$get(`/admin/location/states?country=${selected}`)
          .then((res) => {
            this.$store.commit("locations/SET_STATES", res);
          });
      },
      async fetchCities(selected) {
        await this.$axios
          .$get(`/admin/location/cities?state=${selected.value}&order_by_delayed=true`)
          .then((res) => {
            this.$store.commit("locations/SET_CITIES", res);
          });
      },
    },
    computed: {
        ...mapState({
          currentLocale: state => state.localStorage.currentLocale,
        }),
        ...mapGetters({
          states: ["locations/get_states"],
          cities: ["locations/get_cities"],
        }),
    },

  }
