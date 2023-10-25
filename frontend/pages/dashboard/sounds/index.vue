<template>
  <div class="card_db_wrapper">
    <DeleteModal
      :is-active="isModalActive"
      @confirm="trashConfirm('event-delete-background')"
      @cancel="trashCancel"
    />

    <title-bar :title-stack="titleStack" />
    <div class="countries">
      <div class="level">
        <div class="level-right">
          <Search />
        </div>
        <div class="level-left">
          <nuxt-link
            :to="localePath('dashboard-sounds-create')"
            class="btn btn-success"
            v-show="permissions.includes('files.create')"
          >
            <i class="fas fa-plus"></i>
            {{ $t("admin.create") }}
          </nuxt-link>
        </div>
      </div>

      <div class="table_wrap">
        <Table
          :collection="collection"
          :records="fieldsData"
          :pagination="meta"
          @page-changed="onPageChange($event)"
          @sort-updated="sortingChanged"
        >
          <template v-slot:cell(is_active)="el">
            <span class="table_icon">
              <i
                v-if="el.item.is_active == true"
                class="fas fa-circle green"
              ></i>
              <i
                v-if="el.item.is_active == false"
                class="fas fa-circle red"
              ></i>
            </span>
          </template>
          <template v-slot:cell(appear_for_free_package)="el">
            <span class="table_icon">
              <i
                v-if="el.item.appear_for_free_package == true"
                class="fas fa-circle green"
              ></i>
              <i
                v-if="el.item.appear_for_free_package == false"
                class="fas fa-circle red"
              ></i>
            </span>
          </template>

          <template v-slot:cell(action)="el">
            <nuxt-link
              class="table_icon"
              :to="localePath(`/dashboard/sounds/${el.item.id}/edit`)"
              v-show="permissions.includes('files.update')"
              ><i class="far fa-edit"></i
            ></nuxt-link>

            <span
              class="table_icon mr-2"
              @click="trashModal(el.item.id)"
              v-show="permissions.includes('files.delete')"
              ><i class="far fa-trash-alt red"></i>
            </span>
          </template>
        </Table>
      </div>
    </div>
  </div>
</template>

<script src="./index.js"></script>
