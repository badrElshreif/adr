import { mapState } from "vuex";
import HomeContentService from "../-service/-HomeContentService";

export default {
  props: {
    item: {
      required: false,
    },
  },
  data() {
    return {
      editor: null,
      form: {
        en: {
          title: "",
          body: "",
        },
        ar: {
          title: "",
          body: "",
        },
      },
      param_id: this.$route.params.id,
      submitted: false,
    };
  },
  computed: {
    ...mapState({
      currentLocale: (state) => state.localStorage.currentLocale,
    }),
  },
  async fetch() {
    if (this.param_id) {
      this.reAssignForm();
    }
  },
  fetchOnServer: true,
  methods: {
    reAssignForm() {
      this.form = { ...this.item };
      console.log("thform: ", this.form);
    },
    async submit() {
      this.submitted = true;
      const validData = await this.$validator.validateAll();
      if (validData) {
        if (this.param_id) {
          await HomeContentService.update(this.form, this.param_id)
            .then(() => {
              this.$toast.success(this.$t("admin.updated_successfully"));
              this.submitted = false;
            })
            .catch(() => {
              this.submitted = false;
            });
        } else {
          await HomeContentService.create(this.form)
            .then(() => {
              this.$toast.success(this.$t("admin.created_successfully"));
              this.submitted = false;
            })
            .catch(() => {
              this.submitted = false;
            });
        }
        this.back();
      } else {
        this.submitted = false;
      }
    },
    back() {
      return this.$router.push(this.localePath({ name: "dashboard-home-content" }));
    },
  },
};
