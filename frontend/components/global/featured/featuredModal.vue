<template>
  <modal
    v-if="modalProps"
    :adaptive="true"
    :height="modalProps.height"
    :width="modalProps.width"
    :min-height="modalProps.minHeight"
    :scrollable="modalProps.scrollable"
    name="featuredModal"
    :click-to-close="false"
  >
    <div slot="top-right">
      <button @click="cancelModal">
        x
      </button>
    </div>
    <div class="vs-modal">
      <!--Modal Header-->
      <div class="modal-header">
        <h4>{{ $t('admin.color') }}</h4>
      </div>
        <!--Modal Body-->
        <div class="modal-body">
          <!-- <div class="col-md-12 text-center">
            name
          </div>
            <b-row> -->
                <b-col md="12">
                    <b-form-group
                        :label="$t('admin.color')"
                        label-for="input-horizontal"
                        id="fieldset-horizontal"
                        label-cols-sm="3"
                    >
                    <b-form-input type="color"
                        v-model="form.color"
                        :placeholder="$t('admin.color')"
                        name='color'
                        v-validate="{ required: true, max: 1000 }"
                        :class="{ 'is-invalid': errors.has('color') }"
                    ></b-form-input>
                    <span v-show="errors.has('color')" class="text-error text-danger text-sm">
                    {{ errors.first(`color`) }}
                    </span>
                </b-form-group>
                </b-col>
            </b-row>
        </div>

        <!--Modal Footer-->
        <div class="modal-footer">
          <div class="control">
            <Button @clickFn="confirmModal" size="sm" bgGreen>{{$t('admin.confirm')}}</Button>
            <Button @clickFn="cancelModal" size="sm" bgRed>{{$t('admin.cancel')}}</Button>
          </div>
        </div>
    </div>
  </modal>
</template>

<script src="./main.js"></script>
<style src="./main.css"></style>
