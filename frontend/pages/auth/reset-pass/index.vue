<template>
  <div class="landing_wrapper">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="reg_box border-bottom pb-3 mb-3">
            <h2> {{ $t('front.passRet') }}</h2>
          </div>

          <b-form class="reg_form"  @submit.prevent="handleForm">
            <div class="form-group">
              <label>{{ $t('admin.email') }}</label>

              <b-form-input type="email" name="email" v-model="form.email" v-validate="{ required: true, email: true }">
              </b-form-input>
              <span v-show="errors.has('email')" class="text-error text-danger text-sm">
                {{ errors.first("email") }}
              </span>
            </div>

            <button type="submit" class="btn btn-1"> {{ $t('front.next') }}</button>
          </b-form>
        </div>
      </div>
    </div>

    <UpdatePass :email="form.email" :active="activeModal"/>
  </div>
</template>

<script>
  import UpdatePass from "~/components/auth/UpdatePass.vue";

  export default {
    layout: "website",
    components: {
      UpdatePass
    },
    data() {
      return {
        submitted  : false,
        activeModal: false,
        form       : {

          email: "",

        },
      };
    },
    methods: {
      // toggleShow() {
      //   this.showPassword = !this.showPassword
      // },
      // toggleShow0() {
      //   this.showPassword0 = !this.showPassword0
      // },
      async handleForm() {
        this.submitted   = true;
        this.activeModal = false;

        const validData = await this.$validator.validateAll();

        if (validData) {
          this.create();
        } else {
          this.submitted   = false;
          this.activeModal = false;
        }
      },
      async create() {
        const form_data = new FormData();
        this.form.address = this.address;
        for (const key in this.form) {
          form_data.append(key, this.form[key]);
        }
        await this.$axios
          .post("/company/auth/forget-password", this.form)
          .then((res) => {
            this.submitted   = false;
            this.activeModal = true;
          })
          .catch((err) => {
            this.submitted   = false;
            this.activeModal = false;
          });
      },
    },



  }

</script>

<style lang="scss" scoped>

</style>
