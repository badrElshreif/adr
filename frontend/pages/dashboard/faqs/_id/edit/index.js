import { mapState } from 'vuex'
import formData from '~/pages/dashboard/faqs/-form/-index.vue'

export default {
  layout: "admin",
  components: {
    formData
  },
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData (context) {
    const [ item ] = await Promise.all([
        context.$axios.$get(`/admin/faqs/${context.params.id}`).catch(() => {})
    ])
    return { item }
  },
  data() {
    return {
      titlePage: this.$t('admin.faqs'),
      param_id: this.$route.params.id,
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    }),
    titleStack () {
      return [this.titlePage, this.$t('admin.edit')]
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
