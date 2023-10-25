import AdminService from "./-service/-AdminService";
import {
  mapGetters
} from "vuex";

export default {
  async asyncData(context) {
    let response = await context.$axios
      .$get("/admin/admins?is_paginated=1")
      .catch((e) => {
        console.log("err: ", e);
      });
    return {
      collection: response.data,
      meta      : response.meta,
      links     : response.links,
    };
  },
  data() {
    return {
      titlePage: this.$t("admin.admins"),
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
          key: "roles[0]." + this.$i18n.locale + ".display_name",
          label: this.$t("admin.roles"),
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
          key: "action",
          label: this.$t("admin.actions"),
        },
      ],
      loading      : false,
      publicSearch : "",
      queryParam   : "",
      formFilter   : "",
      locationParam: "",
      customEvents : [
        { eventName: "handle-quick-search", callback: this.handleSearch },
        { eventName: "event-delete-admin", callback: this.handleDelete},
      ],
      permissions: this.$cookies.get("permissions"),
    };
  },
  watch: {
    async $route(to) {
      this.updateLocationParams(to);
      this.doFilterAdmin(this.locationParam);
    },
  },
  mounted() {
    this.$EventBus.$emit("enable-quick-search", true);
    this.updateLocationParams(this.$route);
    this.doFilterAdmin(this.locationParam);
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
    async doFilterAdmin(search) {
      this.formFilter = search;
      this.$nuxt.$loading.start();
        await  this.$axios.$get(`/admin/admins?is_paginated=1&${search}`)
            .then((response) => {
              this.collection= response?.data,
              this.meta      = response?.meta,
              this.links     = response?.links
            })
            .catch(() => {
            this.collection = []
            })
        this.$nuxt.$loading.finish();
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
    async loadAsyncData() {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&is_paginated=1&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}${this.locationParam}`;

      await AdminService.getAll(this.queryParam)
        .then((response) => {
          this.collection = response.data;

          this.meta  = response.meta;
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
      await AdminService.destroy(id)
        .then(() => {
          //* remove this row *//
          this.collection = this.collection.filter((obj) => {
            return obj.id !== id;
          });
          this.$toast.success(this.$t("admin.deleted_successfully"));
        })
        .catch(() => {});
    },
    handleToggleStatus(id) {
      AdminService.toggleStatus(id)
        .then((response) => {
          //* update list *//
          let index = this.collection.findIndex((obj) => obj.id == id);
          if (index >= 0) {
            this.$set(this.collection, index, response);
          }
          this.$toast.success(this.$t("admin.updated_successfully"));
        })
        .catch(() => {});
    },
    exportToExcel() {
      AdminService.excelExport(`?public_search=${this.publicSearch}`).then(
        (response) => {
          this.forceFileDownload(response);
        }
      );
    },
    forceFileDownload(response) {
      const url = window.URL.createObjectURL(new Blob([response]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", "admins.xlsx"); //or any other extension
      document.body.appendChild(link);
      link.click();
    },
    onSelectedRoles(option) {
      this.selected_roles.push(option[0].id);
    },
  },
  computed: {
    titleStack() {
      return [this.$t("admin.admins")];
    },
  },
  head() {
    return {
      title: this.titlePage,
    };
  },
};
