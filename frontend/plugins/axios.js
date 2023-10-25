export default function ({
  context,
  $axios,
  redirect,
  store,
  req,
  app,
  beforeNuxtRender,
  env,
}) {
   let localeUrl = process.env.BASE_URL;

   $axios.setBaseURL(localeUrl);
  function getHeaders(config) {
    //** check for admin authentication or front */
    let accessToken = null;
    let prefix = config.url.split("/");
    if (prefix.includes("admin")) {
      accessToken = app.$cookies.get("mokayiefyToken");
    } else if (prefix.includes("store")) {
      accessToken = app.$cookies.get("storeToken");
    }
    const headers = {
      Accept: "application/json",
      "Content-Type": "application/json",
      "Access-Control-Allow-Origin": "*",
      "Accept-Language": app.i18n.locale,
    };
    headers.Authorization = accessToken || "";
    return headers;
  }

  // Add a request interceptor
  $axios.interceptors.request.use(
    function (config) {
      // Do something before request is sent
      config.headers = getHeaders(config);

      return config;
    },
    function (error) {
      // Do something with request error
      return Promise.reject(error);
    }
  );

  // Add a response interceptor
  $axios.interceptors.response.use(
    function (response) {
      // Do something with response data
      return Promise.resolve(response);
    },
    function (error) {
      const err = error.response.data;
      const baseUrl = error.response.config.url.split("/");
      //* generic error *//
      // console.log(error.response)
      //debugger
      app.$toast.error(err.error);
      if (error.response.status == 403) {
        if (baseUrl.includes("admin"))
          return redirect(app.localePath("dashboard-auth-login"));
        else if (baseUrl.includes("store"))
          return redirect(app.localePath("stores-auth-login"));
        // else if (baseUrl.includes("center"))
        //   return redirect(app.localePath("centers-auth-login"));
      }
      // Do something with response error
      return Promise.reject(err);
    }
  );
}
