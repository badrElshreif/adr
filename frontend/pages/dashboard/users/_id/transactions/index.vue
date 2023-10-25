<template>
  <div class="card_db_wrapper">
    <title-bar :title-stack="titleStack" />
    <div class="countries">
      <div class="level">
        <div class="level-left">
          <button @click="createRow" class="btn btn-info">
            <i class="fas fa-file-excel-o"></i>
            {{ $t("admin.add_transaction") }}
          </button>
        </div>
      </div>
      <div class="table_wrap">
        <Table
          :collection="transactions"
          :records="fieldsData"
          :pagination="meta"
          @page-changed="onPageChange($event)"
        >
          <template v-slot:cell(type)="el">
            <span v-if="el.item.type == 'pay_in'">{{
              $t("admin.pay_in")
            }}</span>
            <span v-else>{{ $t("admin.pay_out") }}</span>
          </template>
        </Table>
      </div>
    </div>
    <formData />
  </div>
</template>

<script src="./index.js"></script>
