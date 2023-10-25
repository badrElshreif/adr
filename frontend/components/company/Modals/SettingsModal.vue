<template>
  <div>
    <b-modal
      id="Settings"
      hide-footer
      hide-header
      ref="my-modal"
      :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'"
    >
      <div class="login_card modal_card p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3>الأعدادات الخاصة بالمستخدم</h3>
          <button class="btn" @click="hideModal">
            <img src="~/assets/new-imgs/foucser/close.png" alt="" />
          </button>
        </div>
        <b-form class="reg_form row">
          <div class="form-group col-12 mb-3">
    <b-form-select
    name="selected"

    v-validate="{ required: true, selected: true }"  v-model="selected" :options="options"></b-form-select>


  <span
    v-show="errors.has('sign_sort')"
    class="text-error text-danger text-sm"
  >
    {{ errors.first("sign_sort") }}
  </span>
</div>
<div class="form-group col-12 mb-3">
    <b-form-select
    name="selected"

    v-validate="{ required: true, selected1: true }"  v-model="selected1" :options="options1"></b-form-select>


  <span
    v-show="errors.has('sign_sort')"
    class="text-error text-danger text-sm"
  >
    {{ errors.first("sign_sort") }}
  </span>
</div>
          <div class="col-12 mb-3">
            <div class="input-group border rounded bg-white">


            <input type="text" class="form-control bg-transparent border-0" value="Speaker ( conexant isst audio driver)">
            <span class="input-group-text bg-transparent border-0 orange" id="basic-addon2">
              اختبار
                </span>
          </div>
          </div>


          <div class="col-12 mb-3" v-for="office in 3" :key="office">
                  <input
                    type="checkbox"
                    name="remember_me"
                    v-model="form.remember_me"
                    :v-validate="{ required: false }"
                    value="1"
                  />
                  <label class="m-0">يتم وضع النصوص النهائية المطلوبة للتصميم</label>
          </div>

          <button   class="btn btn-1 w-100 ">حفظ</button>

        </b-form>

      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  name:'SettingsModal',
  data() {
    return {
      form: {
        remember_me:''



      },
      selected: null,
      options: [
          { value: null, text: 'الكاميرا' },
          { value: 'a', text: 'This is First option' },
          { value: 'b', text: 'Selected Option' },

        ],
        selected1: null,
      options1: [
          { value: null, text: 'ميكروفون' },
          { value: 'a', text: 'This is First option' },
          { value: 'b', text: 'Selected Option' },

        ],
    };
  },
  methods: {
    hideModal() {
      this.$refs["my-modal"].hide();
    },
  },
};
</script>

<style>

.orange{
  color: #DF3C14;
}
</style>
