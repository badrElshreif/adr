<template>
  <b-modal id="activateModal" hide-header hide-footer @show="countDownTimer"
    :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
    <div class="login_card">
      <h2> {{ $t('front.confrmCode') }}</h2>
      <p> {{ $t('front.confrmCode1') }}<span>{{ email }}</span></p>
      <form class=" row mt-3" @submit.prevent="handleForm">
        <div v-for="(input, index) in inputs" :key="input.id" class="col-3">
          <input class="form-control" type="text" pattern="\d*" ref="inputs" maxlength="1"
            @input="moveToNextField($event.target.value, index)" />
        </div>
        <!-- <button class="btn btn-1 w-100">تحقق</button> -->
        <Button type="submit" class="btn btn-1 w-100"> {{ $t('front.verification') }}</Button>

        <div class="text-center d-flex justify-content-center w-100">
          <p class="mt-3 "> {{ $t('front.resend') }} <span>{{ countDown }}</span></p>

        </div>
      </form>
    </div>


  </b-modal>

</template>
<script>
  export default {
    props: ['email', 'active'],
    data() {
      return {
        inputs: [{
          id: "1"
        }, {
          id: "2"
        }, {
          id: "3"
        }, {
          id: "4"
        }],
        countDown: 60,
        form: {
          code : '',
          email : '',
        }
      };
    },
    watch: {
      active(val) {
        if (val == 1) {
          this.$bvModal.show('activateModal');
        } else {
          this.$bvModal.hide('activateModal');

        }
      }
    },
    methods: {
      moveToNextField(value, index) {
        const nextIndex = index + 1;
        if (nextIndex < this.inputs.length && value.length == 1) {
          this.$refs.inputs[nextIndex].focus();
        }
      },
      countDownTimer() {
        if (this.countDown > 0) {
          setTimeout(() => {
            this.countDown -= 1;
            this.countDownTimer();
          }, 1000);
        }
      },
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
        this.form.email = this.email;
        for (const key in this.form) {
          form_data.append(key, this.form[key]);
        }
        this.form.code =
        await this.$axios
          .post("/company/auth/forget-password", this.form)
          .then((res) => {
            this.submitted   = false;
            this.activeModal = true;
            this.$router.replace(this.localePath("/auth/reset-pass/update-pass"));
          })
          .catch((err) => {
            this.submitted   = false;
            this.activeModal = false;
          });
      },
    },
  };

</script>
<style></style>
