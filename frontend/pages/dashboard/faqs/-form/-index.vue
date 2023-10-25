<template>
    <b-form @submit.prevent="submit">

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'en.question\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="en.question"
                    v-model="form.en.question"
                    v-validate="{ required: true,regex: /[\x00-\x7F]+/  }"
                    pattern="[\x00-\x7F]+"
                    :placeholder="$t('admin[\'en.question\']')"
                    :class="{ 'is-invalid': errors.has('en.question') }"
                ></b-form-input>
                <span v-show="errors.has('en.question')" class="text-error text-danger text-sm">
                    {{ errors.first("en.question") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'ar.question\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="ar.question"
                    v-model="form.ar.question"
                    v-validate="{ required: true ,regex: /[\u0621-\u064A]+/}"
                    :placeholder="$t('admin[\'ar.question\']')"

                    pattern="[\u0621-\u064A]+"
                    :class="{ 'is-invalid': errors.has('ar.question') }"
                ></b-form-input>
                <span v-show="errors.has('ar.question')" class="text-error text-danger text-sm">
                    {{ errors.first("ar.question") }}
                </span>
                </b-form-group>
            </b-col>

        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin[\'en.answer\']')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                <b-form-textarea
                    v-model="form.en.answer"
                    :placeholder="$t('admin[\'en.answer\']')"
                    rows="3"
                    max-rows="6"
                    pattern="[\x00-\x7F]+"
                    name='en.answer'
                    v-validate="{ required: true, max: 1000  ,regex: /[\x00-\x7F]+/  }"
                    :class="{ 'is-invalid': errors.has('en.answer') }"
                ></b-form-textarea>
                <span v-show="errors.has(`en.answer`)" class="text-error text-danger text-sm">
                  {{ errors.first(`en.answer`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin[\'ar.answer\']')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                <b-form-textarea
                    v-model="form.ar.answer"
                    :placeholder="$t('admin[\'ar.answer\']')"
                    rows="3"
                    max-rows="6"
                    name='ar.answer'

                    v-validate="{ required: true, max: 1000 ,regex: /[\u0621-\u064A]+/ }"
                    :class="{ 'is-invalid': errors.has('ar.answer') }"
                ></b-form-textarea>
                <span v-show="errors.has(`ar.answer`)" class="text-error text-danger text-sm">
                  {{ errors.first(`ar.answer`) }}
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
