import {mapState} from 'vuex'
import BackgroundService from "../-service/-BackgroundService";
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'

export default {
  props: {
    item: {
      required: false
    },
    itemType: {
      required: true
    },
    is_child: {
      required: false,
      default: false
    },
  },
  data() {
    return {
      form: {
        en                     : {name: ''},
        ar                     : {name: ''},
        appear_for_free_package: true,
        icon                   : '',
        file                   : '',
        type                   : 'background',
      },
      param_id      : this.$route.params.id,
      uploaderFolder: 'backgrounds',
      submitted     : false,
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    })
  },
  async fetch() {
    this.form.type = this.itemType
    if (this.param_id) {
      this.reAssignForm()
    }
  },
  fetchOnServer: true,
  methods: {
    reAssignForm() {
      this.form                = this.cloneItem(this.item);
    },
    async handleUploadFile (e, type = 'image') {
      console.log('tt', type)
      this.submitted = true
      if (e.target.files.length) {
        var imageExt=['png','jpg','jpeg','svg','gif'];
        var videoExt=['mp4'];
        var extension = e.target.files[0].name.split('.').pop().toLowerCase();

        if(! imageExt.includes(extension) && type == 'image'){
          this.$toast.error(this.$t('admin.unsupported_image_format'));
          this.form.icon = '';
          return false;
        } else if(! videoExt.includes(extension) && type == 'video'){
          this.$toast.error(this.$t('admin.unsupported_file_type'));
          this.form.file = '';
          return false;
        } else {
        await UploaderService.uploadSingleFile({
          file: e.target.files[0],
          path: this.uploaderFolder
        })
          .then((response) => {
            if(type == 'image') {
              this.form.icon = response.file
            } else {
              this.form.file = response.file
            }

            this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
            this.submitted = false
          })
          .catch(() => {
            this.submitted = false
          })
        }
      }
  },
    async deleteFile(type = 'image') {
      await UploaderService.deleteSingleFile({
        file: type == 'image' ? this.form.icon : this.form.file,
        path: this.uploaderFolder
      })
        .then(() => {
          if(type == 'image') {
             this.form.icon = ''
          } else if(type == 'video') {
             this.form.file = ''
          }
          this.$refs.fileupload.value = ''
          this.$toast.success(this.$t('admin.attachment_deleted_successfully'))
        })
        .catch(() => {
        })
    },
    async submit() {
      this.submitted = true
      const validData = await this.$validator.validateAll()
      if (validData) {
        if(this.is_child){
          this.$delete(this.form, "units");
        }
        if (this.param_id) {
          this.update()
        } else {
          this.create()
        }
      } else {
        this.submitted = false
      }
    },
    async update() {
      await BackgroundService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
    },
    async create() {
      console.log('thform', this.form)
      await BackgroundService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
    },
    back() {
         return this.$router.push(this.localePath({name: "dashboard-backgrounds"}))
    }
  },
}
