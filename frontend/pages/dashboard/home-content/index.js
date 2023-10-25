import ContentService from "./-service/-HomeContentService";
export default {
  async asyncData(context) {
    //let response = await CategoryService.getAll()
    let response = await context.$axios
      .$get("/admin/home-content?is_paginated=1")
      .catch((e) => {
        console.log("err: ", e);
      });
    return {
      collection: response.data,
      meta: response.meta,
      links: response.links,
    };
  }, //
  data() {
    return {
      titlePage: this.$t("admin.home_content"),
      orderBy: "id",
      orderType: "DESC",
      fieldsData: [
        {
          key: "title",
          label: this.$t("admin.title"),
        },
        // {
        //   key: "is_active",
        //   label: this.$t("admin.status"),
        // },
        {
          key: "action",
          label: this.$t("admin.actions"),
        },
      ],
      loading: false,
      publicSearch: "",
      queryParam: "",
      customEvents: [
        { eventName: "handle-quick-search", callback: this.handleSearch },
        { eventName: "event-delete-content", callback: this.handleDelete },
      ],
      permissions: this.$cookies.get("permissions"),
    };
  },
  mounted() {
    this.$EventBus.$emit("enable-quick-search", true);
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
    handleSearch(search) {
      this.publicSearch = search;
      this.onPageChange(1);
    },
    sortingChanged(ctx) {
      this.orderBy = ctx.sortBy;
      this.orderType = ctx.sortDesc == false ? "ASC" : "DESC";
      this.loadAsyncData();
      // ctx.sortBy   ==> Field key for sorting by (or null for no sorting)
      // ctx.sortDesc ==> true if sorting descending, false otherwise
    },
    /*
     * Load async data
     */
    async loadAsyncData() {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&is_paginated=1&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}`;

      await ContentService.getAll(this.queryParam)
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
    /*
     * Handle page-change event
     */
    onPageChange(page) {
      this.meta.current_page = page;
      this.loadAsyncData();
    },
    async handleDelete(id) {
      await ContentService.destroy(id)
        .then(() => {
          //* remove this row *//
          this.collection = this.collection.filter((obj) => {
            return obj.slug !== id;
          });
          this.$toast.success(this.$t("admin.deleted_successfully"));
        })
        .catch(() => {});
    },
    handleToggleStatus(id) {
      ContentService.toggleStatus(id)
        .then((response) => {
          //* update list *//
          let index = this.collection.findIndex((obj) => obj.slug == id);
          if (index >= 0) {
            this.$set(this.collection, index, response);
          }
          this.$toast.success(this.$t("admin.updated_successfully"));
        })
        .catch(() => {});
    },
  },
  computed: {
    titleStack() {
      return [this.$t("admin.home_content")];
    },
  },
  head() {
    return {
      title: this.titlePage,
    };
  },
};
