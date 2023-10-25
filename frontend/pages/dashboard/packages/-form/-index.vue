<template>
  <b-form @submit.prevent="submit">
    <b-row>
      <b-col md="12">
        <b-form-group :label="$t('admin[\'en.name\']')" label-for="input-horizontal" id="fieldset-horizontal"
          label-cols-sm="2">
          <b-form-input name="en.name" v-model="form.en.name" v-validate="{ required: true }"
            :placeholder="$t('admin[\'en.name\']')" :class="{ 'is-invalid': errors.has('en.name') }"></b-form-input>
          <span v-show="errors.has('en.name')" class="text-error text-danger text-sm">
            {{ errors.first("en.name") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="12">
        <b-form-group :label="$t('admin[\'ar.name\']')" label-for="input-horizontal" id="fieldset-horizontal"
          label-cols-sm="2">
          <b-form-input name="ar.name" v-model="form.ar.name" v-validate="{ required: true }"
            :placeholder="$t('admin[\'ar.name\']')" :class="{ 'is-invalid': errors.has('ar.name') }"></b-form-input>
          <span v-show="errors.has('ar.name')" class="text-error text-danger text-sm">
            {{ errors.first("ar.name") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="12">
        <b-form-group :label="$t('admin[\'en.description\']')" label-for="input-horizontal" id="fieldset-horizontal"
          label-cols-sm="2">
          <b-form-input name="en.description" v-model="form.en.description" v-validate="{ required: true }"
            :placeholder="$t('admin[\'en.description\']')" :class="{ 'is-invalid': errors.has('en.description') }">
          </b-form-input>
          <span v-show="errors.has('en.description')" class="text-error text-danger text-sm">
            {{ errors.first("en.description") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="12">
        <b-form-group :label="$t('admin[\'ar.description\']')" label-for="input-horizontal" id="fieldset-horizontal"
          label-cols-sm="2">
          <b-form-input name="ar.description" v-model="form.ar.description" v-validate="{ required: true }"
            :placeholder="$t('admin[\'ar.description\']')" :class="{ 'is-invalid': errors.has('ar.description') }">
          </b-form-input>
          <span v-show="errors.has('ar.description')" class="text-error text-danger text-sm">
            {{ errors.first("ar.description") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="12" v-if="!form.is_free">
        <b-form-group :label="$t('admin.price')" label-for="input-horizontal" id="fieldset-horizontal"
          label-cols-sm="2">
          <b-form-input name="price" v-model="form.price"
            v-validate="{ required: true,  decimal: 3, min_value: 1 ,max_value:999999}" :placeholder="$t('admin.price')"
            :class="{ 'is-invalid': errors.has('price') }"></b-form-input>
          <span v-show="errors.has('price')" class="text-error text-danger text-sm">
            {{ errors.first("price") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="12">
        <b-form-group :label="$t('admin.months')" label-for="input-horizontal" id="fieldset-horizontal"
          label-cols-sm="2">
          <b-form-input name="months" v-model="form.months" type="number"
            v-validate="{ required: true, min_value:1,max_value:999 }" :placeholder="$t('admin.months')"
            :class="{ 'is-invalid': errors.has('months') }"></b-form-input>
          <span v-show="errors.has('months')" class="text-error text-danger text-sm">
            {{ errors.first("months") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="12">
        <b-form-group :label="$t('admin.is_free')" label-for="input-horizontal" id="fieldset-horizontal3"
          label-cols-sm="2">
          <b-form-radio-group id="radio-group-3" v-model="form.is_free" v-validate="{ required: true }"
            :placeholder="$t('admin.is_free')" :options="options" name="is_free"
            :class="{ 'is-invalid': errors.has('is_free') }"></b-form-radio-group>
          <span v-show="errors.has('is_free')" class="text-error text-danger text-sm">
            {{ errors.first("is_free") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <!-- <b-row>
      <b-col md="12">
        <b-form-group :label="$t('admin.type')" label-for="input-horizontal" id="fieldset-horizontal2"
          label-cols-sm="2">
          <b-form-radio-group id="radio-group-2" v-model="form.type" v-validate="{ required: true }"
            :placeholder="$t('admin.type')" :options="types" name="type"
            :class="{ 'is-invalid': errors.has('type') }"></b-form-radio-group>
          <span v-show="errors.has('type')" class="text-error text-danger text-sm">
            {{ errors.first("type") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row> -->
    <b-row>
      <b-col md="12">
        <b-form-group :label="$t('admin.image')" label-for="input-horizontal" id="fieldset-horizontal"
          label-cols-sm="2">
          <b-form-file :placeholder="$t('admin.choose_file')" :browse-text="$t('admin.browse_file')" accept="image/*"
            name="image" v-model="form.image" v-validate="'required'" ref="fileupload" @change="handleUploadFile"
            :class="{ 'is-invalid': errors.has('image') }"></b-form-file>
          <span v-show="errors.has('image')" class="text-error text-danger text-sm">
            {{ errors.first("image") }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="6"></b-col>
      <b-col md="6">
        <a v-if="form.image != '' && typeof form.image === 'string'" :href="form.image" target="_blank">
          <button @click.prevent="deleteFile" style="color:red; float:right">x</button>
          <b-img :lazy-src="form.image" :src="form.image" max-height="100" max-width="150" class="img-fluid" />
        </a>
      </b-col>
    </b-row>
    <hr style="padding: 30px;" />
    <b-row v-if="form.type == 'global'">
      <b-col md="12" v-for="(setting, index) in settings" :key="index">
        <b-form-group :label="setting.text" label-for="input-horizontal" id="fieldset-horizontal"
          label-cols-sm="2">
          <b-form-input :name="setting.key" v-model="form.settings[index].body" type="number"
            v-validate="{ required: true, min_value:1,max_value:999 }" :placeholder="setting.text" v-if="setting.type == 'number'"
            :class="{ 'is-invalid': errors.has(setting.key) }"></b-form-input>
          <b-form-checkbox :name="setting.key" v-model="form.settings[index].body"
            v-validate="{ required: true, }" :placeholder="setting.text" v-else-if="setting.type == 'checkbox'"
            :class="{ 'is-invalid': errors.has(setting.key) }"></b-form-checkbox>
          <span v-show="errors.has(setting.key)" class="text-error text-danger text-sm">
            {{ errors.first(setting.key) }}
          </span>
        </b-form-group>
      </b-col>
    </b-row>
    <div class="text-center mt-3 mb-2">
      <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
      <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
    </div>

  </b-form>

</template>

<script src="./-index.js"></script>
