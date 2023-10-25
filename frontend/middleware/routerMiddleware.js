export default function ({ app, route, redirect }) {
  if (route.name == null) {
    redirect(app.localePath("/"));
  }
}
