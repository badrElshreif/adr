import { mapState } from 'vuex'
import SettingService from "~/pages/dashboard/settings/-service/-SettingService.js";
export default {
  async asyncData (context) {
    try {
      let url = `/admin/settings`;
      const [ settings ] = await Promise.all([
          context.$axios.$get(url)
      ])
      return { settings }
    }catch (e) {
      console.log('err: ', e)
    }
  },
  data() {
    return {
      titlePage   : this.$t(`admin.settings`),

      form        : {
        settings: [
          {
            key          : null,
            body         : null,
            property_type: {},
            name         : null
          }
        ]
      },
      enableSubmit: false,
      deliveryDueOptions: [
        {
          value: 1,
          text: this.$t('admin.is_value')
        },
        {
          value: 0,
          text: this.$t('admin.is_percentage')
        }
      ],
      options: [
        {
          value: 1,
          text: this.$t('admin.yes')
        },
        {
          value: 0,
          text: this.$t('admin.no')
        }
      ],
      submitted: false
    }
  },
  async fetch() {
    this.form.settings = [... this.settings]
  },
  fetchOnServer: true,
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
  },
  mounted() {
  },
  methods: {
    async doFilterSettings() {
      await this.loadAsyncData();
    },
    async loadAsyncData() {
      this.$nuxt.$loading.start();

      this.$axios.get(`admin/settings`).then((res) => {
        this.form.settings = res.data;
      });
      this.$nuxt.$loading.finish();
    },
    submit () {
      this.submitted = true
      // const validData = this.$validator.validateAll()
      // if (validData) {
      this.$validator.validateAll().then(result => {
          if (!result) {
            this.submitted = false
            return
          }

        this.enableSubmit = true
        SettingService.update(this.form)
        .then(() => {
          this.$toast.success(this.$t('admin.updated_successfully'))
          this.submitted = false
        })
        .catch(() => {
          this.submitted = false
        })
      });
      //}
    }
  }
}
