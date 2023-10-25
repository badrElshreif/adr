<template>
  <b-form @submit.prevent="submit">
    <b-row>
      <b-col md="12">
        <b-form-group
          :label="$t('admin[\'en.title\']')"
          label-for="input-horizontal"
          id="fieldset-horizontal"
          label-cols-sm="2"
        >
          <b-form-input
            :name="$t('admin[\'en.title\']')"
            v-model="form.en.title"
            v-validate="{ required: true }"
            :placeholder="$t('admin[\'en.title\']')"
            :class="{ 'is-invalid': errors.has($t('admin[\'en.title\']')) }"
          ></b-form-input>
          <span
            v-show="errors.has($t('admin[\'en.title\']'))"
            class="text-error text-danger text-sm"
          >
            {{ errors.first($t("admin['en.title']")) }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="12">
        <b-form-group
          :label="$t('admin[\'ar.title\']')"
          label-for="input-horizontal"
          id="fieldset-horizontal"
          label-cols-sm="2"
        >
          <b-form-input
            :name="$t('admin[\'ar.title\']')"
            v-model="form.ar.title"
            v-validate="{ required: true }"
            :placeholder="$t('admin[\'ar.title\']')"
            :class="{ 'is-invalid': errors.has($t('admin[\'ar.title\']')) }"
          ></b-form-input>
          <span
            v-show="errors.has($t('admin[\'ar.title\']'))"
            class="text-error text-danger text-sm"
          >
            {{ errors.first($t("admin['ar.title']")) }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>

    <b-row>
      <b-col md="12">
        <b-form-group
          :label="$t('admin[\'en.body\']')"
          label-for="input-horizontal"
          id="fieldset-horizontal"
          label-cols-sm="2"
        >
          <b-form-textarea
            :placeholder="$t('admin[\'en.body\']')"
            rows="3"
            max-rows="6"
            name="en.body"
            v-model="form.en.body"
            v-validate="{ required: true, max: 1000 }"
            :class="{ 'is-invalid': errors.has('en.body') }"
          ></b-form-textarea>
          <span
            v-show="errors.has('en.body')"
            class="text-error text-danger text-sm"
          >
            {{ errors.first("en.body") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="12">
        <b-form-group
          :label="$t('admin[\'ar.body\']')"
          label-for="input-horizontal"
          id="fieldset-horizontal"
          label-cols-sm="2"
        >
          <b-form-textarea
            :placeholder="$t('admin[\'ar.body\']')"
            rows="3"
            max-rows="6"
            name="ar.body"
            v-model="form.ar.body"
            v-validate="{ required: true, max: 1000 }"
            :class="{ 'is-invalid': errors.has('ar.body') }"
          ></b-form-textarea>
          <span
            v-show="errors.has(`ar.body`)"
            class="text-error text-danger text-sm"
          >
            {{ errors.first(`ar.body`) }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>

    <div class="text-center mt-3 mb-2">
      <Button type="submit" size="sm" bgGreen :disabled="submitted">{{
        $t("admin.save")
      }}</Button>
      <Button @clickFn="back()" size="sm" bgRed>{{ $t("admin.back") }}</Button>
    </div>
  </b-form>
</template>

<script src="./-index.js"></script>
