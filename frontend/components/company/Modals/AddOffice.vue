<template>
  <div>
    <b-modal
      id="AddModal"
      hide-footer
      hide-header
      ref="my-modal"
      :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'"
    >
      <div class="login_card modal_card p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3>اضافة الي مكتب           </h3>
          <button class="btn" @click="hideModal">
            <img src="~/assets/new-imgs/foucser/close.png" alt="" />
          </button>
        </div>
        <b-form class="reg_form row">
          <div class="col-12 mb-3">
            <div class="input-group border rounded bg-white">
            <span class="input-group-text bg-transparent border-0" id="basic-addon2">
                <img src="~/assets/new-imgs/company/ser.png" alt="" />
                </span>

            <input type="search" class="form-control bg-transparent border-0" placeholder="اسم المكتب..">

          </div>
          </div>


          <div class="col-6 mb-3" v-for="office in 10" :key="office">
                  <input
                    type="checkbox"
                    name="remember_me"
                    v-model="form.remember_me"
                    :v-validate="{ required: false }"
                    value="1"
                  />
                  <label class="m-0">اسم المكتب</label>
          </div>

          <button   class="btn btn-1 w-100 ">حفظ</button>

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
