<template>
  <div class="card_db_wrapper">
    <div class="countries">
      <title-bar :title-stack="titleStack" />
    </div>
    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <b-form @submit.prevent="submit" v-if="form.settings">
          <b-row v-for="(setting, index) in form.settings" :key="index">
            <b-col md="12">
              <b-form-group
                :label="setting.name"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  v-if="setting.property_type.key == 'text'"
                  :name="setting.key"
                  v-model="setting.body"
                  v-validate="
                    [
                      'twitter',
                      'instagram',
                      'facebook',
                      'youtube',
                      'google_store',
                      'apple_store',
                    ].includes(setting.key)
                      ? { required: true, url: true }
                      : ['phone', 'whatsapp'].includes(setting.key)
                      ? { required: true, numeric: true, max: 15 }
                      : setting.key == 'email'
                      ? { required: true, email: true }
                      : { required: true }
                  "
                  :placeholder="setting.name"
                  :class="{ 'is-invalid': errors.has(`${setting.key}`) }"
                ></b-form-input>
                <b-form-input
                  v-if="setting.property_type.key == 'number'"
                  :name="setting.key"
                  v-model="setting.body"
                  v-validate="{
                    required: true,
                    numeric: true,
                    min_value: 0,
                    max_value: 100000,
                  }"
                  :placeholder="setting.name"
                  :class="{ 'is-invalid': errors.has(`${setting.key}`) }"
                ></b-form-input>
                <b-form-input
                  v-if="setting.property_type.key == 'decimal'"
                  :name="setting.key"
                  v-model="setting.body"
                  v-validate="
                    setting.key == 'order_added_tax'
                      ? {
                          required: true,
                          decimal: 3,
                          min_value: 0,
                          max_value: 100,
                          max: 100,
                        }
                      : {
                          required: true,
                          decimal: 3,
                          min_value: 0,
                          max_value: 100000,
                          max: 6,
                        }
                  "
                  :placeholder="setting.name"
                  :class="{ 'is-invalid': errors.has(`${setting.key}`) }"
                ></b-form-input>
                <b-form-radio-group
                  v-if="setting.property_type.key == 'radio'"
                  id="radio-group-1"
                  v-model="setting.body"
                  v-validate="{ required: true }"
                  :placeholder="setting.name"
                  :options="setting.key == 'application_delivery_due_type' ? deliveryDueOptions : options"
                  :aria-describedby="ariaDescribedby"
                  :name="setting.key"
                  :class="{ 'is-invalid': errors.has(`${setting.key}`) }"
                ></b-form-radio-group>
                <span
                  v-show="errors.has(`${setting.key}`)"
                  class="text-error text-danger text-sm"
                >
                  {{ errors.first(`${setting.key}`) }}
                </span>
              </b-form-group>
            </b-col>
            <b-form-input v-if="index + 1 == settings.length" type="hidden" class="d-none" v-model="setting.country_id"></b-form-input>
          </b-row>

          <div class="text-center mt-3 mb-2">
            <Button type="submit" size="sm" bgGreen :disabled="submitted">{{
              $t("admin.save")
            }}</Button>
          </div>
        </b-form>
      </card-component>
    </section>
  </div>
</template>

<script src="./index.js"></script>
