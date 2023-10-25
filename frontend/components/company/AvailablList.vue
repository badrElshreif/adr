<template>
  <div>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">المتواجدون (20)</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">اوف لاين</a>
  </li>

</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

   <div class="online_list">
    <div class="online_box d-flex justify-content-between">
      <div class="d-flex align-items-center">
              <img src="~/assets/new-imgs/company/Avatar.png" alt="" class="av">
              <h3>ابو فيصل</h3>

      </div>
      <ul class="d-flex align-items-center">
        <li>
          <button class="btn"><img src="~/assets/new-imgs/company/g1.svg" alt=""></button>
        </li>
        <li>
          <button class="btn"><img src="~/assets/new-imgs/company/g2.svg" alt=""></button>
        </li>
        <!-- <li>
          <button class="btn"><img src="~/assets/new-imgs/company/g1.svg" alt=""></button>
        </li> -->
        <li><span>ادمن</span></li>
      </ul>
    </div>
    <div class="online_box d-flex justify-content-between" v-for="online in 20" :key="online">
      <div class="d-flex align-items-center">
              <img src="~/assets/new-imgs/company/Avatar.png" alt="" class="av">
              <h3>ابو فيصل</h3>

      </div>
      <ul class="d-flex align-items-center">
        <li>
          <button class="btn"><img src="~/assets/new-imgs/company/g3.svg" alt=""></button>
        </li>
        <li>
          <button class="btn"><img src="~/assets/new-imgs/company/g2.svg" alt=""></button>
        </li>

      </ul>
    </div>
   </div>


  </div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
</div>
  </div>
</template>

<script>
export default {

};
</script>
<style scoped lang="scss">
.nav-pills{
  padding: 5px;
  background: #DEDEDE;

  border-radius: 10px;
  .nav-item{
    width: 50%;
  }
  .nav-link {
    text-align: center;
    color:#444;
font-size: 13px;
font-weight: 600;
min-height: 50px;
border-radius: 8px;
display: flex;
    align-items: center;
    justify-content: center;
    &.active{
      background: #DF3C14;
      color: #fff;
    }

}
}
.online_list{
  height: calc(100vh - 272.5px + 76px);
  overflow-y: scroll;
.online_box{
    border-bottom: 1px solid #DEDEDE;
    padding: 10px;
    transition: all ease 0.3s;
&:hover{
  background:#F6F6F6;
}
    h3{
      color: #444;
font-style: normal;
font-weight: 500;
font-size: 14px;

    }
    img.av{
      width: 32px;
height: 32px;
border-radius: 50%;
margin-inline-end: 15px;
    }
    ul{
      li{
        span{
          border-radius: 50px;
border: 1px solid rgba(223, 60, 20, 0.10);
background: rgba(223, 60, 20, 0.10);
padding: 5px 10px;
color: #DF3C14;
        }
      }
    }
  }
}

</style>
