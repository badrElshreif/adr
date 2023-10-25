<template>
  <div class="card_db_wrapper">
    <DeleteModal
      :is-active="isModalActive"
      @confirm="trashConfirm('event-delete-content')"
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
            :to="localePath('dashboard-content-create')"
            class="btn btn-success"
            v-show="permissions.includes('pages.index')"
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
        >
          <!--@sort-updated="sortingChanged"-->
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

          <template v-slot:cell(action)="el">
            <span  v-if="el.item.is_static == 0"
              class="table_icon mr-2"
              @click.prevent="handleToggleStatus(el.item.slug)"
              v-show="permissions.includes('pages.index')"
              :title="`${
                el.item.is_active
                  ? $t('admin.inactiveTitle')
                  : $t('admin.activeTitle')
              }`"
            >
              <i
                :class="`${
                  el.item.is_active
                    ? 'red fa fa-times-circle'
                    : 'green fa fa-check-square'
                }`"
              />
            </span>

            <nuxt-link
              class="table_icon"
              :to="localePath(`/dashboard/content/${el.item.slug}`)"
              v-show="permissions.includes('pages.index')"
              ><i class="far fa-edit"></i
            ></nuxt-link>

            <span
              v-if="el.item.is_static == 0"
              class="table_icon mr-2"
              @click="trashModal(el.item.slug)"
              v-show="permissions.includes('pages.index')"
              ><i class="far fa-trash-alt red"></i>
            </span>
          </template>
        </Table>
      </div>
    </div>
  </div>
</template>

<script src="./index.js"></script>
