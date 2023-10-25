import formData from '~/pages/dashboard/faqs/-form/-index.vue'

export default {
  layout: "admin",
  components: {
    formData
  },
  data() {
    return {
      titlePage: this.$t('admin.faqs'),
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
