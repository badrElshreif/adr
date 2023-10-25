<template>
  <section class="dash-upper-bar">
    <b-container>
      <b-row>
        <b-col sm class="text-center text-sm-right">
          <h4>{{ titlePage }}</h4>
        </b-col>
        <!-- <b-col sm class="text-center text-sm-center">
          <ColorModePicker />
        </b-col> -->
        <b-col sm class="text-center text-sm-left">
          <b-dropdown>
            <template v-slot:button-content>{{
              mokayiefyData ? mokayiefyData.name : ""
            }}</template>
            <b-dropdown-item :to="localePath('dashboard-profile')">{{
              $t("admin.profile")
            }}</b-dropdown-item>
            <b-dropdown-item @click="logout()">{{
              $t("admin.logout")
            }}</b-dropdown-item>
          </b-dropdown>

          <!-- <nuxt-link class="notifi_btn" to="/dashboard/notifications">
            <i class="far fa-bell"></i>
          </nuxt-link> -->
          <b-dropdown class="mr-4">
            <template v-slot:button-content>{{
              $i18n.locale == "en" ? $t("admin.english") : $t("admin.arabic")
            }}</template>
            <b-dropdown-item @click="switchMyLang('ar')"
              >العربية</b-dropdown-item
            >
            <b-dropdown-item @click="switchMyLang('en')"
              >English</b-dropdown-item
            >
          </b-dropdown>
          <b-dropdown class="mr-2 chat_dropdown">
            <template v-slot:button-content>{{
              $t("admin.notifications")
            }}</template>
            <span v-if="notification_list.length > 0">
              <b-dropdown-item
                :to="
                  localePath(`/dashboard/product-orders/${item.data.model_id}`)
                "
                v-for="(item, key) in notification_list"
                :key="key"
              >
                <p class="mb-0">{{ item.data.title }}</p>
                <span> {{ item.data.body }} </span>
              </b-dropdown-item>
              <b-dropdown-item
                class="see_more"
                :to="localePath({ name: 'dashboard-notification-recieved' })"
              >
                {{ $t("admin.see_more") }}
              </b-dropdown-item>
            </span>
            <span v-else>
              <b-dropdown-item>{{ $t("admin.no_results") }}</b-dropdown-item>
            </span>
          </b-dropdown>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
import { mapState } from "vuex";
import AuthService from "~/pages/dashboard/auth/service/AuthService.js";
import ChatService from "~/pages/dashboard/auth/service/ChatService.js";
import moment from "moment";

export default {
  data() {
    return {
      titlePage: "",
      notification_list: [],
      notification_count: "",
      customEvents: [
        { eventName: "reset-chat-counter", callback: this.resetChatCounter },
        { eventName: "load-chat", callback: this.callChats },
      ],
    };
  },
  created() {
    this.callChats();
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
  fetch() {
    this.$colorMode.preference = "light";
  },
  computed: {
    ...mapState({
      currentLocale: (state) => state.localStorage.currentLocale,
      mokayiefyToken: (state) => JSON.parse(state.localStorage.mokayiefyToken),
      mokayiefyData: (state) => JSON.parse(state.localStorage.mokayiefyData),
      role: (state) => state.localStorage.role,
      firebaseToken: (state) => state.localStorage.adminFirebaseToken,
    }),
    currentDate() {
      return moment().lang(this.currentLocale).format("D MMM YYYY");
    },
  },
  name: "app-header",
  // watch: {
  //   $route: function () {
  //     this.name();
  //   },
  // },
  methods: {
    async logout() {
      let loggedInRole = this.role;
      this.$nuxt.$loading.start();

      await AuthService.logout({ device_token: this.firebaseToken })
        .then((res) => {
          this.$store.commit("localStorage/RESET_MOKAYIEFY");
          // this.$cookies.removeAll()
          // if (loggedInRole == 'super_admin')
          this.$router.replace(this.localePath("dashboard-auth-login"));
          this.$toast.success(this.$t("admin.logged_out_successfully"));
        })
        .catch(() => {});
      this.$nuxt.$loading.finish();
    },
    resetChatCounter() {
      this.notification_count = 0;
    },
    callChats() {
      if (process.client) {
        this.messiging();
      }
      this.loadChatsData();
    },
    messiging() {
      const messaging = this.$fire.messaging;
      debugger;
      messaging.onMessage((payload) => {
        console.log("payload", payload);
        this.notification_count++;
        this.notification_list.unshift({
          data: JSON.parse(payload.data.notification).data,
          created_at: this.currentDate,
        });
        if (this.notification_list.length >= 3) {
          this.notification_list.pop();
        }
        let audio = require("@/assets/notification.mp3").default;
        let beeb = new Audio(audio);
        beeb.play();
      });
    },
    async loadChatsData() {
      const response = await Promise.all([
        await this.$axios.$get("/admin/received-notifications"),
        await this.$axios.$get("/admin/received-notifications/count"),
      ]);
      this.notification_list = response[0] ? response[0]?.data : [];
      this.notification_count = response[1] ? response[1]?.chats_count : "";
    },
  },
};
</script>

<style scoped lang="scss">
.dash-upper-bar {
  color: #222222;
  padding: 1em 0;
  background-color: #fff;
  border-radius: 10px;
  @media (max-width: 991px) {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    border-radius: 0;
    background-color: #fff !important;
  }
}
.dash-upper-bar h4 {
  color: var(--color);
}
.notifi_btn {
  border: none;
  color: var(--color-secondary);
  background: none;
  border-radius: 3px;
  width: 40px;
  height: 40px;
  font-size: 20px;
  position: relative;
  top: 4px;
}
.notifi_alert {
  position: absolute;
  background-color: #e02020;
  width: 10px;
  height: 10px;
  display: block;
  top: 0;
  right: 0;
  border-radius: 50%;
}

@media (max-width: 1200px) {
  .dash-upper-bar {
    background-color: #95a5ba33;
  }
}
.chat_dropdown .dropdown-menu {
  @media (max-width: 991px) {
    max-height: 400px;
    overflow-y: auto;
  }
}
</style>

<style lang="scss">
.see_more {
  a {
    color: #e02020;
    font-weight: 600;
    font-size: 15px;
  }
  text-align: center;
}
</style>
