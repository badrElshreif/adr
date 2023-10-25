import Vue from "vue";
import * as VueGoogleMaps from "~/node_modules/vue2-google-maps";

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyD5LCZLdS1cq7-buPkwyLDjcARlFjiljYk",
    libraries: "places",
  },
});
