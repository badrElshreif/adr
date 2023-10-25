<template>
  <div>
    <b-modal id="modal-10" hide-footer hide-header :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'" ref="btnShow">
      <div class="login_card">
        <h2>{{ $t("admin.welcome") }}</h2>
        <b-form class="reg_form pb-3 mb-3 border-bottom" @submit.prevent="login()">
          <div class="">
            <div class="form-group">
              <label>{{ $t("admin.email") }}</label>
              <b-form-input type="email" name="email" v-model="form.email" v-validate="{ required: true, email: true }">
              </b-form-input>
              <span v-show="errors.has('email')" class="text-error text-danger text-sm">
                {{ errors.first("email") }}
              </span>
            </div>

            <div class="form-group">
              <label>{{ $t("admin.password") }}</label>
              <b-input-group class="border align-items-center">
                <b-form-input v-if="showPassword" type="text" name="password" v-model="form.password"
                  v-validate="{ required: true, min: 8 }" class="border-0">
                </b-form-input>
                <b-form-input v-else type="password" name="password" v-model="form.password"
                  v-validate="{ required: true, min: 8 }" class="border-0">
                </b-form-input>
                <b-input-group-prepend class="border-0 p-2">
                  <button class="button btn" @click="toggleShow" type="button">
                    <span class="icon is-small is-right">
                      <i class="fas" :class="{
                          'fa-eye-slash': showPassword,
                          'fa-eye': !showPassword,
                        }"></i>
                    </span>
                  </button>
                </b-input-group-prepend>
              </b-input-group>
              <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                {{ errors.first("password") }}
              </span>
            </div>

            <div class="">
              <div class="d-flex justify-content-between">
                <div class="">
                  <input type="checkbox" name="remember_me" v-model="form.remember_me" :v-validate="{ required: false }"
                    value="1" />
                  <label>{{ $t("admin.remember") }}</label>
                </div>
                <nuxt-link :to="localePath(`/auth/reset-pass`)">
                  {{ $t("admin.forget_password") }}</nuxt-link>
              </div>

              <span v-show="errors.has('remember_me')" class="text-error text-danger text-sm">
                {{ errors.first("remember_me") }}
              </span>
            </div>
          </div>
          <!-- <nuxt-link :to="localePath(`/foucs-dashboard`)" >
            {{ $t("admin.login") }}
          </nuxt-link> -->
          <Button bgRed block type="submit">
            {{ $t("admin.login") }}
            <b-spinner small type="grow" v-if="loading"></b-spinner>
          </Button>
        </b-form>


        <p class="text-center"> {{ $t('front.or') }}</p>
        <ul class="d-flex">
          <li class="m-3">
            <nuxt-link to="/">
              <img src="~/assets/new-imgs/landing/apple.svg" alt="">
            </nuxt-link>
          </li>
          <li class="m-3">
            <nuxt-link to="/">
              <img src="~/assets/new-imgs/landing/playstor.svg" alt="">
            </nuxt-link>
          </li>
        </ul>
      </div>
    </b-modal>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        showPassword: false,
        password: null,
        loading: false,
        form: {
          email: "",
          remember_me: false,
        },
      };
    },
    computed: {
      buttonLabel() {
        return this.showPassword ? "Hide" : "Show";
      },
    },
    methods: {
      toggleShow() {
        this.showPassword = !this.showPassword;
      },
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
            "localStorage/SET_COMPANY_FIREBASE_TOKEN",
            this.notifyToken
          );
          this.$axios.post('/company/auth/login',{
              ...this.form,
              ...{
                device_token: this.notifyToken
              },
            })
            .then((res) => {
              // empty cookie space if center logged in in same browser
              this.logoutFocus();
              let token = JSON.stringify(`${res.data.token_type} ${res.data.access_token}`);
              // for client side rendering

              this.$store.commit("localStorage/SET_COMPANY_TOKEN", token);

              // this.$store.commit("localStorage/SET_ROLE", 'store');
              this.$store.commit(
                "localStorage/SET_COMPANY_PERMISSIONS",
                JSON.stringify(res.data.user.permissions)
              );
              this.$store.commit(
                "localStorage/SET_COMPANY_DATA",
                JSON.stringify({
                  ...(({
                    permissions,
                    ...rest
                  } = res.data.user) => rest)(),
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
              this.$cookies.setAll([{
                  name: "companyToken",
                  value: token,
                  opts: options
                },
                {
                  name: "companyPermissions",
                  value: JSON.stringify(res.data.user.permissions),
                  opts: options,
                },
              ]);

              this.loading = false;
              this.$toast.success(this.$t("admin.logged_in_successfully"));
              this.$router.replace(this.localePath({
                name: "company-dashboard"
              }));
            })
            .catch(() => {
              this.loading = false;
            });
          this.$nuxt.$loading.finish();
        }
      },
      async logoutFocus() {
      if (this.$store.state.localStorage.focusToken) {
        await this.$axios.post('/company/auth/logout')
          .then((res) => {
            this.$store.commit("localStorage/RESET_FOCUS");
          })
          .catch(() => {});
      }
    },
    },
  };

</script>

<style lang="scss"></style>
