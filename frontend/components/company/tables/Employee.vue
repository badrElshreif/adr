<template>
  <div>
    <b-table responsive  :fields="fields" :items="items" borderless :per-page="perPage"
      :current-page="currentPage" >
      <!-- A virtual column -->
      <template #cell(index)="data">
        {{ data.index + 1 }}

      </template>

      <!-- A custom formatted column -->
      <template #cell(details)="data">

       <nuxt-link :to="localePath(`/company-dashboard/employees/details`)" class="add_link">
        التفاصيل
          </nuxt-link>
      </template>
      <template #cell(addToOffice)="data">
       <button class="btn py-0 add_link" v-b-modal.AddModal>
       + اضافة
       </button>
      </template>
      <template #cell(action)="data">
        <ul class="d-flex align-items-center">
          <li>
            <button class="btn py-0 ">
              تعديل
       </button>
          </li>
          <li class="d-lg-block d-md-none d-none">|</li>
          <li>
            <button class="btn py-0 ">
              حذف
       </button>
          </li>
        </ul>

      </template>
      <template #table-caption>عرض 10 سجلات من أصل 50 سجل</template>

    </b-table>

    <!-- <b-pagination
      v-model="currentPage"
      :total-rows="items.length"
      :per-page="perPage"
      align="center"
      :show-numbers="false"

    >
    <template #prev-text>السابق</template>
      <template #next-text>التالي</template>
  </b-pagination> -->
  <!-- add office modal -->
  <AddOffice/>
  </div>
</template>

<script>
import AddOffice from "~/components/company/Modals/AddOffice.vue";

  export default {
    components:{
      AddOffice
    },
    data() {
      return {
      perPage:10, // Number of table rows per page
      currentPage: 1 ,// Current page number
        fields: [
          // A virtual column that doesn't exist in items

          { key: 'index', label: 'التصنيف' },
          // A column that needs custom formatting
          { key: 'name', label: 'اسم الموظف' },
          { key: 'email', label: 'البريد الألكتروني ' },

          { key: 'phonenumber', label: 'رقم الجوال' },

          { key: 'empyNum', label: 'رقم الموظف' },
          { key: 'details', label: 'التفاصيل' },
          { key: 'addToOffice', label: 'اضافة الى مكتب' },

          { key: 'action', label: ' ' },


        ],
        items: [
        { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },
        { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },
        { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },
        { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },
          { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },
          { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },
          { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },
          { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },
          { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },
          { name: 'رامي ابو دياب', email: 'example@mail.com', phonenumber: '52369874',empyNum: '102456',details:''  ,addToOffice: '' ,action: '' },

      ],

      }
    }
  }
</script>
<style lang="scss">
/* .table td, .table th{

  white-space: nowrap;
} */
.add_link{
  color:#444;
font-size: 16px;
font-weight: 400;
text-decoration-line: underline !important;
&:hover{
color: #DF3C14;
}
}
thead{
  border-bottom: 1px solid #ccc;
}
th{
  color: #444;
font-size: 16px;
font-weight: 300;
text-align: center;
}
td{
  color:#171717;
font-size: 16px;
font-weight: 400;
text-align: center;

}
.table.b-table > caption {
    text-align: start;
}
</style>
