import NotificationService from "../-service/-NotificationService";
export default {
  async asyncData(context) {
    //let response = await BrandService.getAll()
    let response = await context.$axios.$get("/admin/received-notifications");

    return {
      collection: response.data,
      meta      : response.meta,
      links     : response.links,
    };
  },
  data() {
    return {
      titlePage: this.$t("admin.recieved_notifications"),
      fieldsData: [
        {
          key: "id",
          label: this.$t("admin.ID"),
        },
        {
          key: "data." + this.$i18n.locale + ".title",
          label: this.$t("admin.title"),
        },
        {
          key: "data." + this.$i18n.locale + ".body",
          label: this.$t("admin.content"),
        },
        {
          key: "created_at",
          label: this.$t("admin.created_at"),
        },
      ],
      loading     : false,
      publicSearch: "",
      queryParam  : "",
      customEvents: [
        { eventName: "handle-quick-search", callback: this.handleSearch },
        { eventName: "event-delete-brand", callback: this.handleDelete },
      ],
      permissions: this.$cookies.get("permissions"),
    };
  },
  watch: {
    async $route(to) {
      this.updateLocationParams(to);
      this.loadAsyncData();
    },
  },
  mounted() {
    this.$EventBus.$emit("enable-quick-search", true);
    this.updateLocationParams(this.$route);
    this.loadAsyncData();
  },
  created() {
    this.customEvents.forEach(
      function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$on(customEvent.eventName, customEvent.callback);
      }.bind(this)
    );
  },
  beforeDestroy() {
    this.customEvents.forEach(
      function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$off(customEvent.eventName, customEvent.callback);
      }.bind(this)
    );
  },
  methods: {
    updateLocationParams(route) {
      this.locationParam = `&country_id=${route.query.country_id || ''}&state_id=${route.query.state_id || ''}&city_id=${route.query.city_id || ''}`;
    },
    handleSearch(search) {
      this.publicSearch = search;
      this.onPageChange(1);
    },
    async loadAsyncData() {
      this.$nuxt.$loading.start();

      this.queryParam = `?is_paginated=1&page=${this.meta.current_page}&public_search=${this.publicSearch}${this.locationParam}`;

      await NotificationService.getAllRecieved(this.queryParam)
        .then((response) => {
          this.collection = response.data;

          this.meta = response.meta;
          this.links = response.links;
        })
        .catch(() => {
          this.collection = [];
        });
      this.$nuxt.$loading.finish();
    },
    onPageChange(page) {
      this.meta.current_page = page;
      this.loadAsyncData();
    },
    async handleDelete(id) {
      await NotificationService.destroy(id)
        .then(() => {
          //* remove this row *//
          this.collection = this.collection.filter((obj) => {
            return obj.id !== id;
          });
          this.$toast.success(this.$t("admin.deleted_successfully"));
        })
        .catch(() => {});
    },
  },
  computed: {
    titleStack() {
      return [this.$t("admin.recieved_notifications")];
    },
    // ...mapState({
    //   currentLocale: state => state.localStorage.currentLocale
    // }),
  },
  head() {
    return {
      title: this.titlePage,
    };
  },
};
