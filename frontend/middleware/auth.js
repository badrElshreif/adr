export default ({app, redirect, store}) => {
  if (process.client) {
    if (!store.state.localStorage.mokayiefyToken) {
      // dashboard-auth-login
      return redirect(app.localePath('/'))
    }
  } else {
    //if (!(app.$cookies.get("mokayiefyToken") && app.$cookies.get("role") == 'super_admin')) {
    if (!app.$cookies.get("mokayiefyToken")) {
      return redirect(app.localePath('/'))

    }
  }
}
