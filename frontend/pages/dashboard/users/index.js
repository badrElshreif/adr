import UserService from "./-service/-UserService";
import {
  mapGetters
} from "vuex";

export default {
  async asyncData(context) {
    let response = await context.$axios
      .$get("/admin/users?is_paginated=1&type=client&status=accepted")
      .catch((e) => {
        console.log("err: ", e);
      });
    return {
      collection: response.data,
      meta      : response.meta,
      links     : response.links,
    };
  },
  watch: {
    async $route(to) {
      this.updateLocationParams(to);
      this.doFilterUser(this.formFilter);
    },
  },
  data() {
    return {
      titlePage: this.$t("admin.users"),
      orderBy: "id",
      orderType: "DESC",
      fieldsData: [
        {
          key: "id",
          label: this.$t("admin.ID"),
          sortable: true,
        },
        {
          key: "name",
          label: this.$t("admin.name"),
          sortable: true,
        },
        {
          key: "email",
          label: this.$t("admin.email"),
        },
        {
          key: "country_code",
          label: this.$t("admin.country_code"),
          sortable: true,
        },
        {
          key: "phone",
          label: this.$t("admin.phone"),
        },
        {
          key: "is_active",
          label: this.$t("admin.status"),
          sortable: true,
        },
        {
          key: "created_at",
          label: this.$t("admin.created_at"),
          sortable: true,
        },
        {
          key: "verification_code",
          label: this.$t("admin.verification_code"),
        },
        {
          key: "action",
          label: this.$t("admin.actions"),
        },
      ],
      loading      : false,
      publicSearch : "",
      queryParam   : "",
      locationParam: "",
      formFilter   : "",
      customEvents : [
        { eventName: "handle-quick-search", callback: this.handleSearch },
        { eventName: "event-delete-user", callback: this.handleDelete },
        { eventName: "deactivate-item-event", callback: this.toggleStatus },
      ],
      permissions: this.$cookies.get("permissions"),
    };
  },
  mounted() {
    this.$EventBus.$emit("enable-quick-search", true);
    this.updateLocationParams(this.$route);
    this.doFilterUser(this.formFilter);
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
    async doFilterUser(search) {
      this.loadAsyncData(search);
    },
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
    async loadAsyncData(search = null) {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&is_paginated=1&status=accepted&type=client&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}${this.locationParam}`;

      await UserService.getAll(this.queryParam)
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
    handleToggleStatus(item) {
      if (!item.is_active) this.toggleStatus({ id: item.id, reason: "" });
      else this.deactivateModal(item.id);
    },
    toggleStatus(item) {
      UserService.toggleStatus(item.id, { reason: item.reason }).then(
        (response) => {
          //* update list *//
          let index = this.collection.findIndex((obj) => obj.id == item.id);
          if (index >= 0) {
            this.$set(this.collection, index, response);
          }
          this.$toast.success(this.$t("admin.updated_successfully"));
        }
      );
    },
    async handleDelete(id) {
      await UserService.destroy(id)
        .then(() => {
          //* remove this row *//
          this.collection = this.collection.filter((obj) => {
            return obj.id !== id;
          });
          this.$toast.success(this.$t("admin.deleted_successfully"));
        })
        .catch(() => {});
    },
    exportToExcel() {
      UserService.excelExport(`?public_search=${this.publicSearch}`).then(
        (response) => {
          this.forceFileDownload(response);
        }
      );
    },
    forceFileDownload(response) {
      const url = window.URL.createObjectURL(new Blob([response]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", "users.xlsx"); //or any other extension
      document.body.appendChild(link);
      link.click();
    },
  },
  computed: {
    titleStack() {
      return [this.$t("admin.users")];
    },
    ...mapGetters({
      states   : ["locations/get_states"],
      cities   : ["locations/get_cities"],
      countries: ["locations/get_countries"],
    }),
  },
  head() {
    return {
      title: this.titlePage,
    };
  },
};
