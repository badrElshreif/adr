import AuthService from "~/pages/dashboard/auth/service/AuthService.js";

export default {
  layout: "login",
  // middleware:'auth',
  data() {
    return {
      loading: false,
      titlePage: this.$t("admin.login"),
      form: {
        email: "",
        password: "",
        remember_me: false,
      },
      notifyToken: null,
    };
  },
  methods: {
    async getDeviceToken() {
      const messaging = this.$fire.messaging;
      await messaging
        .getToken()
        .then(() => {
          return messaging.getToken();
        })
        .then((currentToken) => {
          if (currentToken) {
            this.notifyToken = currentToken;
            return currentToken;
          }
        })
        .catch((err) => {
          console.warn("Your browser does not support fcm !");
        });
    },
    async login() {
      const validData = await this.$validator.validateAll();
      if (validData) {
        this.loading = true;

        await this.getDeviceToken();
        this.$store.commit(
          "localStorage/SET_ADMIN_FIREBASE_TOKEN",
          this.notifyToken
        );

        AuthService.login({
          ...this.form,
          ...{ device_token: this.notifyToken },
        })
          .then((res) => {
            let token = JSON.stringify(`${res.token_type} ${res.access_token}`);
            // for client side rendering
            this.$store.commit("localStorage/SET_MOKAYIEFY_TOKEN", token);
            this.$store.commit("localStorage/SET_ROLE", "super_admin");
            this.$store.commit(
              "localStorage/SET_MOKAYIEFY_PERMISSIONS",
              JSON.stringify(res.user.permissions)
            );
            this.$store.commit(
              "localStorage/SET_MOKAYIEFY_DATA",
              JSON.stringify({
                ...(({ permissions, ...rest } = res.user) => rest)(),
              })
            );
            // for ssr rendering
            if (this.form.remember_me == true) {
              var options = {
                path: "/",
                maxAge: 60 * 60 * 24 * 14,
              };
            } else if (this.form.remember_me == false) {
              var options = {
                path: "/",
                maxAge: 60 * 60 * 24 * 7,
              };
            }
            this.$cookies.setAll([
              { name: "mokayiefyToken", value: token, opts: options },
              { name: "role", value: "super_admin", opts: options },
              {
                name: "permissions",
                value: JSON.stringify(res.user.permissions),
                opts: options,
              },
            ]);
            this.loading = false;
            this.$toast.success(this.$t("admin.logged_in_successfully"));
            this.$router.replace(this.localePath({ name: "dashboard" }));
          })
          .catch(() => {
            this.loading = false;
          });
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
