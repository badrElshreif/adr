<template>
  <div class="display:inline" style="width: 100%;  padding: 3em 0 0 0;">
    <!-- <b-row>
      <b-col md="4">
        <b-form-group :label="$t('admin.country')" label-for="input-horizontal" id="fieldset-horizontal"
          label-cols-sm="3" class="align-items-center">
          <multiselect v-model="form.country_id" :options="countries" value="value"
            :close-on-select="true" :clear-on-select="false" :hide-selected="false" :preserve-search="true"
            :placeholder="$t('admin.select') + ' ' + $t('admin.country') + '  '" label="name" :allowEmpty="true" :preselect-first="false" name="country"
            v-validate="{ required: true }">
            <span slot="noOptions">
              {{ $t("admin.empty_list") }}
            </span>
            <span slot="noResult">
              {{ $t("admin.no_results") }}
            </span>
          </multiselect>
          <span v-show="errors.has($t('admin.country'))" class="text-error text-danger text-sm">
            {{ errors.first($t("admin.country")) }}
          </span>
        </b-form-group>
      </b-col>
      <b-col md="4" v-if="!$route.path.includes('settings')">
        <b-form-group :label="$t('admin.state')" label-for="input-horizontal" id="fieldset-horizontal" label-cols-sm="3"
          class="align-items-center">
          <multiselect v-model="form.state_id" :options="states" :close-on-select="true"
            :placeholder="$t('admin.state')" :name="$t('admin.state')" track-by="value" label="name"
            v-validate="{ required: true }">
            <span slot="noOptions">
              {{ $t("admin.empty_list") }}
            </span>
            <span slot="noResult">
              {{ $t("admin.no_results") }}
            </span>
          </multiselect>
        </b-form-group>
      </b-col>
      <b-col md="3" v-if="!$route.path.includes('settings')">
        <b-form-group :label="$t('admin.city')" label-for="input-horizontal" id="fieldset-horizontal" label-cols-sm="3"
          class="align-items-center">
          <multiselect v-model="form.city_id" :options="cities" :close-on-select="true" :placeholder="$t('admin.city')"
            :name="$t('admin.city')" track-by="value" label="name" v-validate="{ required: true }">
            <span slot="noOptions">
              {{ $t("admin.empty_list") }}
            </span>
            <span slot="noResult">
              {{ $t("admin.no_results") }}
            </span>
          </multiselect>
        </b-form-group>
      </b-col>
      <b-col md="1">
        <a @click="resetFilter" class="btn btn-dark">
        <i class="fas fa-undo"></i>
      </a>
      </b-col>
    </b-row> -->
  </div>
</template>

<script src="./-index.js"></script>
