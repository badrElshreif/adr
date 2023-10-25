import { mapState } from 'vuex'
import FaqService from "../-service/-FaqService";
export default {
  layout: "admin",
    props: {
        item: {
            required: false
        }
    },
    data() {
      return {
        form: {
          en: {
            question: '',
            answer: ''
          },
          ar: {
            question: '',
            answer: ''
          },
          is_active: true,
        },
        param_id: this.$route.params.id,
        submitted: false
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    async fetch() {
      if (this.param_id) {
        this.reAssignForm()
      }
    },
    watch:{
      'form.en.answer'(current) {
        const pattern = /\x00-\x7F+/
        console.log( pattern.test(current))

        return pattern.test(current)
      },
      'form.ar.answer'(current) {
        const patterns = /\u0621-\u064A+/
        return patterns.test(current)
      }
    },


    fetchOnServer: true,
    methods: {
      reAssignForm () {
        this.form = {...this.item}
      },
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        //debugger
        if (validData) {
          if (this.param_id) {
            this.update()
          } else {
            this.create()
          }
        }else{
          this.submitted = false
        }
      },
      update () {
        FaqService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      create () {
        FaqService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-faqs" }))
      },

    // allLetter()
    //   {
    //     const pattern = /^[A-Za-z]+$/
    //     pattern.test(current)
    //    var letters = /^[A-Za-z]+$/;
    //    if(inputtxt.value.match(letters))
    //      {
    //       return true;
    //      }
    //    else
    //      {
    //      alert("message");
    //      return false;
    //      }
    //   }



    },
  }
