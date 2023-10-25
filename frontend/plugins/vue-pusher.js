import Vue from "vue";

Vue.use(require("vue-pusher"), {
  api_key: "0d25afd538bb0b0066e1",
  options: {
    cluster: "eu",
    encrypted: true,
  },
});
