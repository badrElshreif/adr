<template>
  <div class="card_db_wrapper">
    <div class="countries">
      <title-bar :title-stack="titleStack" />
    </div>
    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <b-form @submit.prevent="submit">
          <b-row>
            <b-col md="12">
              <b-form-group :label="$t('admin.country')" label-for="input-horizontal" id="fieldset-horizontal"
                label-cols-sm="2" class="align-items-center">
                <multiselect v-model="form.country_id" :options="countries.map((obj) => obj.value)"
                  :custom-label="(opt) => countries.find((obj) => obj.value == opt).name" value="key"
                  :close-on-select="true" :clear-on-select="false" :hide-selected="false" :preserve-search="true"
                  :placeholder="$t('admin.countries')" :name="$t('admin.countries')" label="key" id="key"
                  name="country_id" v-validate="{ required: true }">
                  <span slot="noOptions">
                    {{ $t("admin.empty_list") }}
                  </span>
                  <span slot="noResult">
                    {{ $t("admin.no_results") }}
                  </span>
                </multiselect>
                <span v-show="errors.has($t('admin.countries'))" class="text-error text-danger text-sm">
                  {{ errors.first($t("admin.countries")) }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>
          <div class="text-center mt-3 mb-2">
            <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t("admin.generate_settings")}}</Button>
            <Button @clickFn="back()" size="sm" bgRed>{{ $t("admin.back") }}</Button>
          </div>
        </b-form>
      </card-component>
    </section>
  </div>
</template>

<script src="./index.js"></script>
