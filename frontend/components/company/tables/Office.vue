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
        الذهاب الى المكتب
          </nuxt-link>
      </template>
      <!-- <template #cell(addToOffice)="data">
       <button class="btn py-0 add_link" v-b-modal.AddModal>
       + اضافة
       </button>
      </template> -->
      <template #cell(action)="data">
        <ul class="d-flex align-items-center">
          <li>
            <button class="btn py-0 ">
              تعديل
       </button>
          </li>
          <li class="d-lg-block d-md-none d-none">|</li>
          <li>
            <button class="btn py-0 add_link ">
              حذف
       </button>
          </li>
        </ul>

      </template>
      <template #cell(action2)="data">
        <div>
  <b-dropdown id="dropdown-1"  variant="link" no-caret>
    <template #button-content>
      <img src="~/assets/new-imgs/company/list.png" alt="" />
    </template>
    <b-dropdown-item>فتح</b-dropdown-item>
    <b-dropdown-item>غلق</b-dropdown-item>
  </b-dropdown>
</div>
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
          { key: 'name', label: 'اسم المكتب' },
          { key: 'sort', label: 'نوع المكتب' },

          { key: 'empynumber', label: 'عدد الموظفين' },

          { key: 'attend', label: 'عدد الحاضرين' },
          { key: 'details', label: 'التفاصيل' },

          { key: 'action', label: ' ' },
          { key: 'action2', label: ' ' },


        ],
        items: [
        { name: 'مكتب التصميم', sort: 'عام', empynumber: '22',attend: '22',details:''  , action: '' ,action2: ''  },
        { name: 'مكتب التصميم', sort: 'عام', empynumber: '22',attend: '22',details:''  , action: '' ,action2: ''  },
        { name: 'مكتب التصميم', sort: 'عام', empynumber: '22',attend: '22',details:''  , action: '' ,action2: ''  },
        { name: 'مكتب التصميم', sort: 'عام', empynumber: '22',attend: '22',details:''  , action: '' ,action2: ''  },
        { name: 'مكتب التصميم', sort: 'عام', empynumber: '22',attend: '22',details:''  , action: '' ,action2: ''  },
        { name: 'مكتب التصميم', sort: 'عام', empynumber: '22',attend: '22',details:''  , action: '' ,action2: ''  },
        { name: 'مكتب التصميم', sort: 'عام', empynumber: '22',attend: '22',details:''  , action: '' ,action2: ''  },

      ],

      }
    }
  }
</script>
<style lang="scss" scoped>

.add_link{
  color: #DF3C14;


}

</style>
