<template>
  <div>
    <b-table responsive  :fields="fields" :items="items" borderless :per-page="perPage"
      :current-page="currentPage" >
      <!-- A virtual column -->
      <template #cell(index)="data">
        {{ data.index + 1 }}

      </template>

 



      <template #cell(sort)="data">
        <div class="d-flex justify-content-around">
          <b-form-checkbox
      id="checkbox-1"
      v-model="status"
      name="checkbox-1"
      value="accepted"
      unchecked-value="not_accepted"
    >
    بيان
    </b-form-checkbox>
    <b-form-checkbox
      id="checkbox-2"
      v-model="status"
      name="checkbox-2"
      value="accepted"
      unchecked-value="not_accepted"
    >
    بيان
    </b-form-checkbox>
    <b-form-checkbox
      id="checkbox-3"
      v-model="status"
      name="checkbox-3"
      value="accepted"
      unchecked-value="not_accepted"
    >
    بيان
    </b-form-checkbox>
        </div>
      </template>
      <template #cell(status)="data">
     <!-- <span class="green">نشط</span> -->
     <span class="orange">غير نشط</span>

      </template>
      <template #cell(action2)="data">
        <div>
    <label class="switch">
      <input type="checkbox" v-model="isChecked">
      <span class="slider round"></span>
    </label>
  </div>

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
            <button class="btn py-0 add_link ">
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
        isChecked: false,

      perPage:10, // Number of table rows per page
      currentPage: 1 ,// Current page number
        fields: [
          // A virtual column that doesn't exist in items

          { key: 'index', label: 'التصنيف' },
          // A column that needs custom formatting
          { key: 'name', label: 'اسم الدور' },
          { key: 'sort', label: 'الصلاحية' },

          { key: 'status', label: 'الحالة' },

          { key: 'action2', label: 'تفعيل/الغاء' },

          { key: 'action', label: ' ' },


        ],
        items: [
        { name: 'مكتب التصميم',sort:'' , status:'' , action2:'' , action:'' , },

        { name: 'مكتب التصميم',sort:'' , status:'' , action2:'' , action:'' , },
        { name: 'مكتب التصميم',sort:'' , status:'' , action2:'' , action:'' , },
        { name: 'مكتب التصميم',sort:'' , status:'' , action2:'' , action:'' , },
        { name: 'مكتب التصميم',sort:'' , status:'' , action2:'' , action:'' , },
        { name: 'مكتب التصميم',sort:'' , status:'' , action2:'' , action:'' , },
        { name: 'مكتب التصميم',sort:'' , status:'' , action2:'' , action:'' , },


      ],

      }
    },

  computed: {
    toggleIcon() {
      return this.isChecked ? faToggleOn : faToggleOff;
    }
  }
  }
</script>
<style lang="scss" scoped>

.add_link{
  color: #DF3C14;


}
.green{
  color: #38A169;
}
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
    height: 25px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc; /* Default color */
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 30px;
    width: 30px;
    left: 0px;
    bottom: -2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  filter: drop-shadow(0px 3px 6px rgba(175, 84, 1, 0.25));
}

input:checked + .slider {
  background-color: #DF3C14; /* Custom color when switched on */
}

input:focus + .slider {
  box-shadow: 0 0 1px #DF3C14;
}

input:checked + .slider:before {
  -webkit-transform: translateX(37px);
  -ms-transform: translateX(37px);
  transform: translateX(37px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>
