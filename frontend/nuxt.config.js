import webpack from "webpack";
import { version } from "./package.json";
const fs = require("fs");

export default {
  head: {
    title: "Ceotus",
    htmlAttrs: {
      lang: "en",
    },
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      { hid: "description", name: "description", content: "" },
      { name: "format-detection", content: "telephone=no" },
    ],
    link: [
      // { rel: "icon", type: "image/x-icon", href: "/favicon.ico" },
      { rel: "preconnect", href: "https://fonts.googleapis.com" },
      {
        rel: "stylesheet",
        href: "https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap",
      },
      {
        rel: "stylesheet",
        href: "https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;900&display=swap",
      },
      { rel: 'stylesheet', href: 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' }

    ],
    script: [
      { src: 'https://code.jquery.com/jquery-3.6.0.slim.min.js', body: true },
      { src: 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js', body: true },
      { src: 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', body: true }
    ],

  },
  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    // "~/assets/css/global.css",
    "~/assets/css/style.scss",
    "~/assets/css/responsive.css",

    "~/assets/vendors/font-awesome/css/all.min.css",
    "~/assets/vendors/animte/animte.css",
  ],
  loading: "~/components/Spinner.vue",
  loading: true,

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    { src: "~/plugins/vee-validate" },
    { src: "~/plugins/i18n" }, //** call first time in application */
    { src: "~/plugins/axios" },
    { src: "~/plugins/event-bus" },
    { src: "~plugins/vue-js-modal.js" },
    { src: "~/plugins/chart.js", mode: "client" },
    { src: "~/plugins/vue-pusher" },
    { src: "~/plugins/vue-google-maps",  ssr: false  },
  ],
  generate: {
    routes: ["/"],
  },
  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    "@nuxtjs/color-mode",
    '@nuxtjs/dotenv',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    "@nuxtjs/axios",
    "@nuxtjs/toast",
    "@tui-nuxt/editor",
    "bootstrap-vue/nuxt",
    "nuxt-vue-multiselect",
    "cookie-universal-nuxt",
    "@nuxt/image",
    "nuxt-vuex-localstorage",
    [
      "nuxt-i18n",
      {
        lazy: true,
        loadLanguagesAsync: true,
        // vueI18n: i18n,
        locales: [
          {
            name: "English",
            code: "en",
            iso: "en-US",
            file: "en/index.js",
            // dir: 'en/'
          },
          {
            name: "Arabic",
            code: "ar",
            iso: "ar-AR",
            file: "ar/index.js",
            // dir: 'ar/'
          },
        ],
        langDir: "locales/",
        defaultLocale: "ar",
        fallbackLocale: "ar",
        strategy: "prefix",
        detectBrowserLanguage: {
          useCookie: true,
          cookieKey: "i18n_redirected",
        },
        rootRedirect: "ar",
      },
    ],
    "@nuxtjs/firebase",
  ],
  firebase: {
    config: {
      apiKey: "AIzaSyAYyce_o4pC1KYN5pEktGanaXOzWyI6288",
      authDomain: "shoplo-80327.firebaseapp.com",
      projectId: "shoplo-80327",
      storageBucket: "shoplo-80327.appspot.com",
      messagingSenderId: "831418037461",
      appId: "1:831418037461:web:b61da5911a86076e929e5c",
      measurementId: "G-W01FNZQN9D",
    },
    services: {
      messaging: {
        createServiceWorker: true,
        fcmPublicVapidKey:
          "BGSDW5DayvewEKwY5QsRAet6gW890bRNcPd_NCUsxOb8vUH9vfAWr3krlgFPf1xCQxPUAv-q2v8eTbZ54jwVLv8",
        inject: fs.readFileSync("./serviceWorker.js"),
      },
    },
  },
  serverMiddleware: {
    "/_ipx": "~/server/middleware/ipx.js",
  },
  // https://openbase.com/js/vue-toasted/documentation
  toast: {
    position: "top-center",
    duration: 3000,
    theme: "toasted-primary", // ['toasted-primary', 'outline', 'bubble']
    register: [
      // Register custom toasts
      {
        name: "my-error",
        message: "Oops...Something went wrong",
        options: {
          type: "error",
        },
      },
    ],
  },
  router: {
    middleware: "routerMiddleware",
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
    postcss:false,

    babel: {
      compact: true,
    },
    extend(config, ctx) {
      config.module.rules.push({
        test: /\.(ogg|mp3|wav|mpe?g)$/i,
        loader: "file-loader",
        options: {
          name: "[path][name].[ext]",
        },
      });
    },
    loaders: {
      vue: {
        prettify: false,
      },
    },
    plugins: [
      new webpack.DefinePlugin({
        "process.VERSION": version,
      }),
    ],

  },
};
