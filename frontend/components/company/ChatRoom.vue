<template>
  <div>
    <div class="chat_room">
            <div class="chat_header">
              <div class="d-flex align-items-center">
              <img src="~/assets/new-imgs/company/Avatar.png" alt="">
              <h3>ابو فيصل</h3>

              </div>
            </div>
            <div class="chat_body">
            </div>
            <div class="chat_footer">
              <div class="input-group border rounded bg-white">


<input type="text" class="form-control bg-transparent border-0" placeholder="اكتب رسالة">
<span class="input-group-text bg-transparent border-0 orange" id="basic-addon2">
<ul class="d-flex">
<li>
  <button class="btn"><img src="~/assets/new-imgs/company/s1.svg" alt="">
</button>
</li>
<li>
  <button class="btn"><img src="~/assets/new-imgs/company/s2.svg" alt="">
</button>
</li>
<li>
  <button class="btn"><img src="~/assets/new-imgs/company/s3.svg" alt="">
</button>
</li>
</ul>
    </span>
</div>
            </div>
          </div>
  </div>
</template>

<script>
  export default {

  }
</script>

<style lang="scss">
.chat_room{
  height: calc(100vh - 108.5px);
  background: url(~/assets/new-imgs/company/bg-chat.png) no-repeat ;
  background-size: cover;
  .chat_header{
    height: 60px;
    border-bottom: 1px solid  #DEDEDE;
background:#F6F6F6;
padding: 10px;
display: flex;
align-items: center;
img{
  width: 32px;
height: 32px;
margin-inline-end: 15px;
}
h3{
  color: var(--Gray-Text, #444);
text-align: right;
font-family: Cairo;
font-size: 14px;
font-style: normal;
font-weight: 500;
line-height: 120%; /* 16.8px */
}
  }
  .chat_body{
    height: calc(100vh - 272.5px );
    // overflow-x: scroll;
    overflow-y: scroll;

  }
  .chat_footer{
    margin: 50px;
    margin-top: 20px;
    input{
      height: 100%;
      padding: 1rem;
      &:focus{
        box-shadow: unset;
      }
    }
  }
}

</style>
