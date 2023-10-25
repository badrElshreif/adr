<template>
  <div class="col-12">
    <b-table responsive  :fields="fields" :items="items" borderless :per-page="perPage"
      :current-page="currentPage" >
      <!-- A virtual column -->
      <template #cell(index)="data">
        {{ data.index + 1 }}

      </template>

      <!-- A custom formatted column -->
      <!-- <template #cell(name)="data">
        00
      </template> -->

      <!-- A virtual composite column -->
      <!-- <template #cell(nameage)="data">
        {{ data.item.name.first }} is {{ data.item.age }} years old
      </template> -->

      <!-- Optional default data cell scoped slot -->
      <!-- <template #cell()="data">
        {{ data.value }}
      </template> -->
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
  </div>
</template>

<script>

  export default {
    data() {
      return {
      perPage:10, // Number of table rows per page
      currentPage: 1 ,// Current page number
        fields: [
          // A virtual column that doesn't exist in items

          { key: 'index', label: 'التصنيف' },
          // A column that needs custom formatting

          { key: 'date', label: 'التاريخ' },

          { key: 'timeIn', label: 'وقت الدخول ' },
          { key: 'timeOut', label: 'وقت الخروج ' },
          { key: 'hourDay', label: 'عدد الساعات' },

          { key: 'notes', label: 'ملاحظات' },


        ],
        items: [
          {   date: '12/08/2023 Saturday' ,timeIn: '08:00 AM' ,timeOut: '07:00 PM' ,hourDay: '8 ساعة' ,notes: '' },

                    {   date: '12/08/2023 Saturday' ,timeIn: '08:00 AM' ,timeOut: '07:00 PM' ,hourDay: '8 ساعة' ,notes: '' },

                    {   date: '12/08/2023 Saturday' ,timeIn: '08:00 AM' ,timeOut: '07:00 PM' ,hourDay: '8 ساعة' ,notes: '' },
                    {   date: '12/08/2023 Saturday' ,timeIn: '08:00 AM' ,timeOut: '07:00 PM' ,hourDay: '8 ساعة' ,notes: '' },
                    {   date: '12/08/2023 Saturday' ,timeIn: '08:00 AM' ,timeOut: '07:00 PM' ,hourDay: '8 ساعة' ,notes: '' },
                    {   date: '12/08/2023 Saturday' ,timeIn: '08:00 AM' ,timeOut: '07:00 PM' ,hourDay: '8 ساعة' ,notes: '' },

        ],

      }
    }
  }
</script>
<style>
/* .table td, .table th{

  white-space: nowrap;
} */
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
