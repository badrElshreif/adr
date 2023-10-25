<template>
  <div>
    <b-modal
      id="PayModal"
      hide-footer
      hide-header
      ref="my-modal"
      :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'"
    >
      <div class="login_card modal_card p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3>الدفع</h3>
          <button class="btn" @click="hideModal">
            <img src="~/assets/new-imgs/foucser/close.png" alt="" />
          </button>
        </div>
        <b-form class="reg_form row">
          <div class="form-group col-12">
    <label>{{ $t('admin.name') }}</label>

  <b-form-input
    type="text"
    name="username"
    v-model="form.username"
    v-validate="{ required: true, text: true }"
  >
  </b-form-input>
  <span
    v-show="errors.has('name')"
    class="text-error text-danger text-sm"
  >
    {{ errors.first("name") }}
  </span>
          </div>
          <div class="form-group col-12">
    <label>رقم الكارت</label>

  <b-form-input
    type="text"
    name="cardNumber"
    v-model="form.cardNumber"
    v-validate="{ required: true, text: true }"
  >
  </b-form-input>
  <span
    v-show="errors.has('name')"
    class="text-error text-danger text-sm"
  >
    {{ errors.first("name") }}
  </span>
</div>
<div class="form-group col-md-6">
    <label>رقم الكارت</label>

  <b-form-input
    type="text"
    name="cardDate"
    v-model="form.cardDate"
    v-validate="{ required: true, text: true }"
  >
  </b-form-input>
  <span
    v-show="errors.has('name')"
    class="text-error text-danger text-sm"
  >
    {{ errors.first("name") }}
  </span>
</div>
<div class="form-group col-md-6">
    <label>رقم الكارت</label>

  <b-form-input
    type="text"
    name="cardCvv"
    v-model="form.cardCvv"
    v-validate="{ required: true, text: true }"
  >
  </b-form-input>
  <span
    v-show="errors.has('name')"
    class="text-error text-danger text-sm"
  >
    {{ errors.first("name") }}
  </span>
</div>
<div class="col-12">
                  <input
                    type="checkbox"
                    name="remember_me"
                    v-model="form.remember_me"
                    :v-validate="{ required: false }"
                    value="1"
                  />
                  <label>حفظ بيانات الكارت</label>
                </div>
          <button   class="btn btn-1 w-100 ">سداد</button>

        </b-form>

      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        username:'',
        cardNumber:'',
        cardDate:'',
        cardCvv:'',
        remember_me:''

      },
    };
  },
  methods: {
    hideModal() {
      this.$refs["my-modal"].hide();
    },
  },
};
</script>

<style lang="scss">
// .btn_blue{
//   background-color: #7477FF !important;
// }
</style>
