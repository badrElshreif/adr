<template>
  <div class="landing_wrapper">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="reg_box border-bottom pb-3 mb-3">
            <h2> {{ $t("front.signCard1") }}</h2>
            <h2> {{ $t("front.signCard2") }}</h2>
            <p> {{ $t("front.signCard3") }}</p>
            <ul class="d-flex">
              <li class="m-2">
                <nuxt-link to="">
                  <img src="~/assets/new-imgs/landing/apple.svg" alt="">
                </nuxt-link>
              </li>
              <li class="m-2">
                <nuxt-link to="">
                  <img src="~/assets/new-imgs/landing/playstor.svg" alt="">
                </nuxt-link>
              </li>
            </ul>
            <h5> {{ $t("front.signCard4") }} <button v-b-modal.modal-10>{{ $t("admin.login") }}</button>
            </h5>
          </div>
          <h5 class="mb-4"> {{ $t("front.signCard5") }}</h5>
          <b-form class="reg_form" @submit.prevent="handleForm">
            <div class="">
              <div class="form-group">
                <label>{{ $t('admin.name') }}</label>
                <b-form-input type="text" name="username" v-model="form.username" v-validate="{ required: true }">
                </b-form-input>
                <span v-show="errors.has('name')" class="text-error text-danger text-sm">
                  {{ errors.first("name") }}
                </span>
              </div>
              <div class="form-group">
                <label>{{ $t('admin.email') }}</label>

                <b-form-input type="email" name="email" v-model="form.email"
                  v-validate="{ required: true, email: true }">
                </b-form-input>
                <span v-show="errors.has('email')" class="text-error text-danger text-sm">
                  {{ errors.first("email") }}
                </span>
              </div>

              <div class="form-group ">
                <label>{{ $t('admin.phone') }}</label>
                <b-input-group class="border align-items-center">

                  <b-form-input class="border-0" type="text" name="phone" v-model="form.phone"
                    v-validate="{ required: true }">
                  </b-form-input>

                  <b-input-group-prepend class="border-0 p-2">
                    <b-dropdown id="dropdown-1" text="+966" class="bg-transparent" v-model="form.country_code">
                      <b-dropdown-item value="+966">+966</b-dropdown-item>
                    </b-dropdown>
                  </b-input-group-prepend>
                </b-input-group>
                <span v-show="errors.has('phone')" class="text-error text-danger text-sm">
                  {{ errors.first("phone") }}
                </span>
              </div>
              <div class="form-group">
                <label>{{ $t('front.sign_sort') }}</label>
                <b-form-select name="selected" v-validate="{ required: true }" v-model="form.type" :options="options">
                </b-form-select>


                <span v-show="errors.has('sign_sort')" class="text-error text-danger text-sm">
                  {{ errors.first("sign_sort") }}
                </span>
              </div>
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

              <!-- <div class="form-group ">
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
              </div> -->

              <div class="">
                <input type="checkbox" name="terms" v-model="terms" :v-validate="{ required: true }" />
                <label> {{ $t("front.signCard6") }}<nuxt-link to="/"> {{ $t("front.signCard7") }}</nuxt-link></label>
                <span v-show="errors.has('terms')" class="text-error text-danger text-sm">
                  {{ errors.first("terms") }}
                </span>
              </div>
            </div>
            <button type="submit" class="btn btn-1">{{ $t('front.sign') }}</button>
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
        selected: null,
        submitted: false,
        options: [{
            value: null,
            text: this.$t('admin.select_type')
          },
          {
            value: 'company',
            text: this.$t('admin.company')
          },
          {
            value: 'focus',
            text: this.$t('admin.focus')
          },

        ],
        showPassword: false,
        showPassword0: false,
        terms: false,


        form: {
          username    : '',
          email       : "",
          phone       : "",
          type        : "company",
          password    : "",
          country_code: "966",
          remember_me : false,
        },
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
      async handleForm() {
        this.submitted = true;
        const validData = await this.$validator.validateAll();

        if (validData) {
          this.create();
        } else {
          this.submitted = false;
        }
      },
      async create() {
        const form_data = new FormData();
        this.form.address = this.address;
        for (const key in this.form) {
          form_data.append(key, this.form[key]);
        }
        await this.$axios
          .post("/company/auth/register", this.form)
          .then((res) => {
            this.submitted = false;
            this.$toast.success(this.$t("admin.send_to_admin"));
            this.$router.replace(this.localePath("/"));
          })
          .catch((err) => {
            this.submitted = false;
          });
      },
    },
    components: {
      Login
    },
  }

</script>

<style lang="scss" scoped>

</style>
