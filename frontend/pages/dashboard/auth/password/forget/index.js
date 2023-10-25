import AuthService from "~/pages/dashboard/auth/service/AuthService.js";

export default {
  layout: "login",
  data() {
    return {
      loading: false,
      titlePage: this.$t("admin.change_password"),
      form: {
        email: "",
      },
    };
  },
  methods: {
    async submit() {
      const validData = await this.$validator.validateAll();
      if (validData) {
        this.loading = true;
        await AuthService.forgetPassword(this.form)
          .then((res) => {
            this.$toast.success(this.$t("admin.code_sent_successfully"));
            this.$store.commit("localStorage/SET_FORGET_MAIL", this.form.email);
            this.$router.replace(
              this.localePath({ name: "dashboard-auth-password-reset" })
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
