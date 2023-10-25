import { mapState } from 'vuex'
import formData from '~/pages/dashboard/content/-form/-index.vue'

export default {
  components: {
    formData
  },
  // validate ({ params }) {
  //   if (params.id) {
  //     return !isNaN(params.id)
  //   }
  //   return true
  // },
  data() {
    return {
      titlePage: this.$t('admin.static_pages'),
    }
  },
  computed: {
    titleStack () {
      return [this.titlePage, this.$t('admin.create')]
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
