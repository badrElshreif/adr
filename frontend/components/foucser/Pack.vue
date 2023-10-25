<template>
  <div class="row pack_foucs">
    <div class="col-12">

      <div class="d-lg-flex justify-content-between p-3 shadow-sm rounded pack_head_dash">
        <div class="d-flex align-items-center">
        <img src="~/assets/new-imgs/foucser/p4.svg" alt="" />

        <div class="">
          <h5>إسم الباقة</h5>
          <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز</p>
        </div>
      </div>
      <div class="text-center">
        <p class="w-100">500 ر.س</p>
        <h3>الباقة تنتهي في 12 سبتمبر 2023</h3>
      </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="why_box">
        <img src="~/assets/new-imgs/foucser/p1.svg" alt="" />

        <h4>إسم الباقة</h4>
        <h4><b>500 ر.س</b></h4>
        <h4>وصف العضوية</h4>
        <p>
          هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي
          القارئ عن التركيز
        </p>
        <button v-b-modal.PayModal class="btn btn-outline-danger mt-3">أشتراك</button>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="why_box">
        <img src="~/assets/new-imgs/foucser/p2.svg" alt="" />

        <h4>إسم الباقة</h4>
        <h4><b>500 ر.س</b></h4>
        <h4>وصف العضوية</h4>
        <p>
          هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي
          القارئ عن التركيز
        </p>
        <button v-b-modal.PayModal class="btn btn-outline-danger mt-3">أشتراك</button>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="why_box">
        <img src="~/assets/new-imgs/foucser/p3.svg" alt="" />

        <h4>إسم الباقة</h4>
        <h4><b>500 ر.س</b></h4>
        <h4>وصف العضوية</h4>
        <p>
          هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي
          القارئ عن التركيز
        </p>
        <button v-b-modal.PayModal class="btn btn-outline-danger mt-3">أشتراك</button>
      </div>
    </div>
    <PayModal/>
  </div>
</template>

<script>
import PayModal from "~/components/foucser/Modals/PayModal.vue";

export default {
  components:{
    PayModal
  }
};
</script>

<style lang="scss" scoped>
.pack_foucs {
  position: relative;
    z-index: 1;
  .why_box {
    margin: 25px;
    margin-bottom: 50px;
    // margin-inline-start: 0;
    text-align: center;
    padding: 70px 0;
    border-radius: 8px;
    // border: 1px solid #DEDEDE;
    // margin-bottom: 0.5rem;
    background: #f8f7ff;
    position: relative;
    transition: all ease-in-out 0.3s;
    &::before {
      // content: url(../new-imgs/landing/shape.svg);
      content: "";
      position: absolute;
      width: 100%;
      height: 110%;
      background-color: #7477ff;
      border-radius: 16px;
      top: -3px;
    right: -27px;
      transform: rotate(-4deg);
      z-index: -1;
      opacity: 0;
      transition: all ease-in-out 0.3s;
    }

    &:hover {
      border-radius: 16px;
      transition: all ease-in-out 0.3s;
      background-color: #fff;
    }
    &:hover::before {
      opacity: 1;
      transition: all ease-in-out 0.3s;
    }

    h4 {
      margin: 1rem 0;
      color: #171717;
      font-size: 16px;
      font-weight: 600;
      text-transform: capitalize;
      b {
        color: #7477ff;
        font-weight: 500;
      }
    }
    p {
      color: #444;
      font-size: 14px;
      font-weight: 300;
      width: 85%;
      margin: 0 auto;
    }

  .btn-outline-danger {
    border-radius: 8px;
    border: 1px solid #7477ff !important;
    // min-width: 200px;
    height: 42px;
    width: 80%;
    color: #7477ff;
    &:hover {
      color: #fff;
      background-color: #7477ff !important;
    }
    &:focus{
      box-shadow: unset;
    }
  }
  }
  .pack_head_dash{
    margin-bottom: 30px;
    h5{
      color: #1E293B;
font-size: 16px;
font-weight: 600;
margin-bottom: 0.2rem;
    }
    p{
      color: #1E293B;
font-size: 14px;
font-weight: 300;
width: 70%;
    }
    img{
width: 50.239px;
height: 50.239px;
border-radius: 50%;
margin-inline-end: 15px;
    }
    h3{
      border-radius: 36px;
      // background: #f8f7ff;
padding:5px 10px;
// color: #7477ff;
text-align: right;
font-size: 13px;
font-weight: 400;
margin-top: 0.3rem;
text-align: center;
line-height: 22px;
color: var(--Primary, #DF3C14);
background: var(--Tint1, #FFF7F5);
    }
  }
}
</style>
