<template>
  <div>
    <b-table
      borderless
      :items="collection"
      :fields="records"
      no-local-sorting
      @sort-changed="sortingChanged"
      show-empty
      responsive
    >
      <template #empty>
        <div class="text-center">{{ $t("admin.no_data") }}</div>
      </template>
      <template
        v-for="dataTableSlot in Object.keys($scopedSlots)"
        v-slot:[dataTableSlot]="slotScope"
      >
        <slot :name="dataTableSlot" v-bind="slotScope" />
      </template>
      <!--<div> No Data</div>-->
    </b-table>

    <b-row v-if="pagination" class="align-items-center">
      <b-col lg="6" class="my-1">
        {{ $t("admin.showing_page_number") }}
        {{ collection.length ? current_page : 0 }}
      </b-col>

      <b-col v-if="pagination" lg="6" class="my-1">
        <b-pagination
          v-model="current_page"
          :total-rows="pagination.total"
          :per-page="pagination.per_page"
          :last-page="pagination.last_page"
          pills
          align="right"
          @input="$emit('page-changed', current_page)"
          class="my-3 heavy-rain-gradient"
        />
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  props: {
    collection: {
      type: Array,
      default: null,
    },
    records: {
      type: Array,
      default: null,
    },
    pagination: {
      type: Object,
      default: () => {},
    },
  },

  data() {
    return {
      total: 1,
      current_page: 1,
      per_page: 10,
      last_page: "",
      search_input: "",
    };
  },
  methods: {
    sortingChanged(ctx) {
      this.$emit("sort-updated", ctx);
    },
  },
};
</script>

<style scoped lang="scss">
.table {
  font-size: 14px;
}
table {
  border-collapse: separate;
  border-spacing: 0 20px;
}
.table thead th {
  text-align: center !important;
}
table[data-v-4e6ff006] {
  border-collapse: separate;
  border-spacing: 2px;
  // border: 2px solid #f1f1f1;
}
</style>
