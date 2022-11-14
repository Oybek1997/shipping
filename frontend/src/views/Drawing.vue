<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        {{ $t('Excelga ma`lumot yuklash') }}
        <v-spacer></v-spacer>
        <v-btn
          @click="drawingModal = true"
          style="background-color:rgb(51, 122, 183); color: white"
          class="ml-8"
        >
          {{ $t('drawing.upload') }}
        </v-btn>
      </v-card-title>

      <v-dialog
        v-model="drawingModal"
        persistent
        max-width="450px"
        @keydown.esc="drawingModal = false"
      >
        <v-card>
          <v-card-title>
            <span class="headline">{{ $t('drawing.mplupload') }}</span>
            <v-spacer></v-spacer>
            <v-btn color="red" x-small fab class @click="drawingModal = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text class="pb-0 mt-5">
            <v-container>
              <v-row>
                <v-col class="pt-0" cols="12">
                  <v-file-input
                    v-model="files"
                    label="Faylni tanlang"
                    outlined
                    dense
                  ></v-file-input>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions class="pt-0">
            <v-spacer></v-spacer>
            <v-btn color="green" dark @click="uploadMPL">{{
              $t('drawing.upload')
            }}</v-btn>
            <v-spacer></v-spacer>
            <!--                        <v-btn color="red darken-1" dark @click="onClickOutside">{{ $t('close') }}</v-btn>-->
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="loading" width="300" hide-overlay>
        <v-card color="primary" dark>
          <v-card-text>
            {{ $t('loadingText') }}
            <v-progress-linear
              indeterminate
              color="white"
              class="mb-0"
            ></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-card>
  </div>
</template>
<script>
// const moment = require("moment");
import Swal from 'sweetalert2';
export default {
  data() {
    return {
      loading: false,
      drawingModal: false,
      files: null,
    };
  },
  computed: {
    screenHeight() {
      return window.innerHeight - 210;
    },
  },
  methods: {
    uploadMPL() {
      let formData = new FormData();
      formData.append('file', this.files);
      this.files = [];
      this.$axios
        .post(this.$store.state.backend_url + '/api/mplImport', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        .then(() => {
          this.files = null;
          this.drawingModal = false;
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer);
              toast.addEventListener('mouseleave', Swal.resumeTimer);
            },
          });
          Toast.fire({
            icon: 'success',
            title: this.$t('create_update_operation'),
          });
        });
    },
    closeViewPart() {
      this.viewPart = false;
      this.partnumFiles = [];
    },

    screenWidth() {
      return window.innerWidth;
    },
  },
  mounted() {
    document.title = this.$t('drawings');
    // this.downloadPart();
    // this.getAllFile();
  },
};
</script>
<style>
.itemWidth {
  width: 15%;
}
.dialogHeight {
  max-height: 80%;
}
</style>
