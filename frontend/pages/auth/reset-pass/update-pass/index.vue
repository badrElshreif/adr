<template>
  <div class="landing_wrapper">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="reg_box border-bottom pb-3 mb-3">
            <h2> {{ $t('front.passRet') }}</h2>
          </div>
          <b-form class="reg_form">



            <div class="form-group ">
              <label>{{ $t('admin.password') }}</label>
              <b-input-group class="border align-items-center">

                <b-form-input v-if="showPassword" type="text" name="password" v-model="form.password"
                  v-validate="{ required: true, min: 8 }" class="border-0">
                </b-form-input>
                <b-form-input v-else type="password" name="password" v-model="form.password"
                  v-validate="{ required: true, min: 8 }" class="border-0">
                </b-form-input>
                <b-input-group-prepend class="border-0 p-2">
                  <button class="button btn" @click="toggleShow" type="button">
                    <span class="icon is-small is-right">
                      <i class="fas" :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"></i>
                    </span>
                  </button>
                </b-input-group-prepend>
              </b-input-group>
              <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                {{ errors.first("password") }}
              </span>
            </div>

            <div class="form-group ">
              <label>{{ $t('admin.confirm_password') }}</label>
              <b-input-group class="border align-items-center">

                <b-form-input v-if="showPassword0" type="text" name="confirm_password" v-model="form.confirm_password"
                  v-validate="{ required: true, min: 8 }" class="border-0">
                </b-form-input>
                <b-form-input v-else type="password" name="confirm_password" v-model="form.confirm_password"
                  v-validate="{ required: true, min: 8 }" class="border-0">
                </b-form-input>
                <b-input-group-prepend class="border-0 p-2">
                  <button class="button btn " @click="toggleShow0" type="button">
                    <span class="icon is-small is-right">
                      <i class="fas" :class="{ 'fa-eye-slash': showPassword0, 'fa-eye': !showPassword0 }"></i>
                    </span>
                  </button>
                </b-input-group-prepend>
              </b-input-group>
              <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                {{ errors.first("password") }}
              </span>
            </div>
            <button type="submit" class="btn btn-1"> {{ $t('front.confrm') }}</button>
          </b-form>
        </div>
      </div>
    </div>

    <!-- <login></login> -->

  </div>
</template>

<script>
  import Login from "~/components/auth/Login.vue";

  export default {
    layout: "website",
    data() {
      return {
        form: {

          showPassword: false,
          password: null,
          showPassword0: false,
          confirm_password: null,
        }



      };
    },
    computed: {
      buttonLabel() {
        return this.showPassword ? 'Hide' : 'Show'
      },
      buttonLabel() {
        return this.showPassword0 ? 'Hide' : 'Show'
      },
    },
    methods: {
      toggleShow() {
        this.showPassword = !this.showPassword
      },
      toggleShow0() {
        this.showPassword0 = !this.showPassword0
      },
    },
    components: {
      Login
    },
  }

</script>

<style lang="scss" scoped>

</style>
