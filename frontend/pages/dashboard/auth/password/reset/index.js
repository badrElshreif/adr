import AuthService from "~/pages/dashboard/auth/service/AuthService.js";
import { mapState } from "vuex";

export default {
  layout: "login",
  props: {
    email: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      loading: false,
      titlePage: this.$t("admin.change_password"),
      form: {
        password: "",
        token: "",
        password_confirmation: "",
      },
    };
  },
  computed: {
    ...mapState({
      forgetMail: (state) => state.localStorage.forgetMail,
    }),
  },
  methods: {
    async submit() {
      const validData = await this.$validator.validateAll();
      if (validData) {
        this.loading = true;
        await AuthService.resetPassword({
          ...this.form,
          ...{ email: this.forgetMail },
        })
          .then((res) => {
            this.$store.commit("localStorage/SET_FORGET_MAIL", null);
            this.$toast.success(this.$t("admin.updated_successfully"));
            this.$router.replace(
              this.localePath({ name: "dashboard-auth-login" })
            );
          })
          .catch(() => {});
        this.loading = false;
        this.$nuxt.$loading.finish();
      }
    },
  },
  head() {
    return {
      title: this.titlePage,
    };
  },
};
