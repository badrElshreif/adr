<template>
    <b-form @submit.prevent="submit">
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'en.name\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="en.name"
                    v-model="form.en.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'en.name\']')"
                    :class="{ 'is-invalid': errors.has('en.name') }"
                ></b-form-input>
                <span v-show="errors.has('en.name')" class="text-error text-danger text-sm">
                    {{ errors.first("en.name") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'ar.name\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="ar.name"
                    v-model="form.ar.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'ar.name\']')"
                    :class="{ 'is-invalid': errors.has('ar.name') }"
                ></b-form-input>
                <span v-show="errors.has('ar.name')" class="text-error text-danger text-sm">
                    {{ errors.first("ar.name") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'en.description\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="en.description"
                    v-model="form.en.description"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'en.description\']')"
                    :class="{ 'is-invalid': errors.has('en.description') }"
                ></b-form-input>
                <span v-show="errors.has('en.description')" class="text-error text-danger text-sm">
                    {{ errors.first("en.description") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'ar.description\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="ar.description"
                    v-model="form.ar.description"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'ar.description\']')"
                    :class="{ 'is-invalid': errors.has('ar.description') }"
                ></b-form-input>
                <span v-show="errors.has('ar.description')" class="text-error text-danger text-sm">
                    {{ errors.first("ar.description") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.password')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="password"
                    v-model="form.password"
                    v-validate="{ required: false }"
                    :placeholder="$t('admin.password')"
                    :class="{ 'is-invalid': errors.has('password') }"
                ></b-form-input>
                <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                    {{ errors.first("password") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.appear_for_free_package')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-checkbox
                    name="appear_for_free_package"
                    v-model="form.appear_for_free_package"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin.appear_for_free_package')"
                    :class="{ 'is-invalid': errors.has('appear_for_free_package') }"
                ></b-checkbox>
                <span v-show="errors.has('appear_for_free_package')" class="text-error text-danger text-sm">
                    {{ errors.first("appear_for_free_package") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
         <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin.audio')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2">
                    <b-form-file
                    :placeholder="$t('admin.choose_file')"
                    :browse-text="$t('admin.browse_file')"
                    name="audio"
                    ref="fileupload"
                    @change="handleUploadFile($event, 'audio')"
                    :class="{ 'is-invalid': errors.has('audio') }"
                    v-model="form.file"
                    v-validate="'url'"
                    ></b-form-file>
                    <span v-show="errors.has(`audio`)" class="text-error text-danger text-sm">
                      {{ errors.first(`audio`) }}
                    </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6"></b-col>
            <b-col md="6">
                <a v-if="form.file != '' && typeof form.file === 'string'" :href="form.file" target="_blank">
                    <audio controls>
                        <source :src="form.file" type="audio/ogg">
                      </audio>
                  </a>
            </b-col>
        </b-row>
      <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
      </div>

    </b-form>

</template>

<script src="./-index.js"></script>
