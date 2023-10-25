export default ({app, redirect, store}) => {
  debugger
  if (process.client) {
    if (!store.state.localStorage.companyToken) {
      return redirect(app.localePath('companies-auth-login'))
    }
  } else {
    //if (!(app.$cookies.get("mokayiefyToken") && app.$cookies.get("role") == 'super_admin')) {
    if (!app.$cookies.get("companyToken")) {
      return redirect(app.localePath('companies-auth-login'))
    }
  }
}
