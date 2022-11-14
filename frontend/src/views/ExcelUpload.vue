<template>
  <div class="fullHeight home">
    <v-row>
      <v-col class="pa-0" md="12" sm="12" xs="12">
        <v-card class="home_card">
          <v-card-text>
            <v-row class="ma-3" style="display: flex; justify-content: center;">
              <v-col md="3" sm="3" xs="12" v-if="user.role.id == 1">
                <v-hover v-slot="{ hover }">
                  <v-card
                    :color="color1"
                    dark
                    :elevation="hover ? 24 : 0"
                    @click="uploadselect(1)"
                  >
                    <v-card-title class="text-h7 textEllipsis"
                      >Umummiy hisobot uchun yuklash</v-card-title
                    >
                    <v-card-text>
                      <v-icon large>mdi-car-cog</v-icon>
                    </v-card-text>
                  </v-card>
                </v-hover>
              </v-col>
              <v-col
                md="3"
                sm="3"
                xs="12"
                v-if="user.role.id == 2 || user.role.id == 1"
              >
                <v-hover v-slot="{ hover }">
                  <v-card
                    :color="color2"
                    dark
                    :elevation="hover ? 24 : 0"
                    @click="uploadselect(2)"
                  >
                    <v-card-title class="text-h7 textEllipsis"
                      >Kunlik 04 malumotlarni yuklash</v-card-title
                    >
                    <v-card-text>
                      <v-icon large>mdi-city</v-icon>
                    </v-card-text>
                  </v-card>
                </v-hover>
              </v-col>
              <v-col
                md="3"
                sm="3"
                xs="12"
                v-if="user.role.id == 2 || user.role.id == 1"
              >
                <v-hover v-slot="{ hover }">
                  <v-card
                    :color="color3"
                    dark
                    :elevation="hover ? 24 : 0"
                    @click="uploadselect(3)"
                  >
                    <v-card-title class="text-h7 textEllipsis"
                      >O`rnatilgan detallarni yuklash</v-card-title
                    >
                    <v-card-text>
                      <v-icon large>mdi-car</v-icon>
                    </v-card-text>
                  </v-card>
                </v-hover>
              </v-col>

              <v-col
                md="3"
                sm="3"
                xs="12"
                v-if="user.role.id == 7 || user.role.id == 1"
              >
                <v-hover v-slot="{ hover }">
                  <v-card
                    :color="color4"
                    dark
                    :elevation="hover ? 24 : 0"
                    @click="uploadselect(4)"
                  >
                    <v-card-title class="text-h7 textEllipsis"
                      >Omborlarga jonatilganlarni yuklash</v-card-title
                    >

                    <v-card-text>
                      <v-icon large>mdi-database</v-icon>
                    </v-card-text>
                  </v-card>
                </v-hover>
              </v-col>
              <v-col
                md="3"
                sm="3"
                xs="12"
                v-if="user.role.id == 2 || user.role.id == 1"
              >
                <v-hover v-slot="{ hover }">
                  <v-card
                    :color="color5"
                    dark
                    :elevation="hover ? 24 : 0"
                    @click="uploadselect(5)"
                  >
                    <v-card-title class="text-h7 textEllipsis"
                      >(700)ga o`tganlarni yuklash</v-card-title
                    >

                    <v-card-text>
                      <v-icon large>mdi-database</v-icon>
                    </v-card-text>
                  </v-card>
                </v-hover>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
        <v-card-title v-if="upload">
          <v-spacer></v-spacer>
          <v-file-input
            v-model="files"
            label="Faylni tanlang"
            outlined
            dense
            accept=".xls*"
            hide-details
          ></v-file-input>
          <v-btn class="mx-5 my-5" color="green" dark @click="uploadMPL">{{
            $t('drawing.upload')
          }}</v-btn>
          <v-spacer></v-spacer>
        </v-card-title>
        <v-divider class="my-10 mx-10"></v-divider>
      </v-col>
    </v-row>

    <v-dialog width="30%" v-model="errormodal" hide-overlay>
      <v-card color="white" dark>
        <v-card-title>
          <v-spacer></v-spacer>
          <v-btn color="red" x-small fab class @click="errormodal = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text v-if="errorvehicle != ''" style="color:black">
          {{ 'error1' }}
          <p style="color:red" v-for="item in errorvehicle" :key="item.indexof">
            {{ item.vin + ' malumotlar bazasiga qo`shilmagan!' }}
          </p>
        </v-card-text>

        <v-card-text v-if="errordetail != ''" style="color:black">
          {{ 'error2' }}
          <p style="color:red" v-for="item in errordetail" :key="item.indexof">
            {{ item.detail + ' detal bazada mavjud emas!' }}
          </p>
        </v-card-text>
        <v-card-text v-if="errororder != ''" style="color:black">
          {{ 'error3' }}
          <p style="color:red" v-for="item in errororder" :key="item.indexof">
            {{ item.vin + ' avtoga ' + item.detail + ' belgilanmagan!' }}
          </p>
        </v-card-text>
        <v-card-text v-if="errororuser != ''" style="color:black">
          {{ 'error3' }}
          <p style="color:red" v-for="item in errororuser" :key="item.indexof">
            {{ item.user + ' ushbu xodim bazada yo`q! ' }}
          </p>
        </v-card-text>
        <v-card-text v-if="errororwarehous != ''" style="color:black">
          {{ 'error3' }}
          <p style="color:red" v-for="item in errororerror" :key="item.indexof">
            {{ item.errordata + ' Ba`zadan farqli! ' }}
          </p>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import Swal from 'sweetalert2';
export default {
  data() {
    return {
      loading: false,
      upload: false,
      files: null,
      ulrExcel: '',
      errormodal: false,
      errordata: '',
      errorvehicle: '',
      errordetail: '',
      errororder: '',
      errororuser: '',
      errororerror: '',
      color1: '#385F73',
      color2: '#385F73',
      color3: '#385F73',
      color4: '#385F73',
      color5: '#385F73',
    };
  },
  computed: {
    screenHeight() {
      return window.innerHeight - 210;
    },
    user() {
      return this.$store.state.user;
    },
  },
  methods: {
    uploadselect(e) {
      if (e == 1) {
        this.color1 = 'blue';
        this.color2 = '#385F73';
        this.color3 = '#385F73';
        this.color4 = '#385F73';
        this.color5 = '#385F73';
        this.ulrExcel = '/api/mplImport';
      } else if (e == 2) {
        this.color2 = 'blue';
        this.color1 = '#385F73';
        this.color3 = '#385F73';
        this.color4 = '#385F73';
        this.color5 = '#385F73';
        this.ulrExcel = '/api/mplImportday';
      } else if (e == 3) {
        this.color3 = 'blue';
        this.color1 = '#385F73';
        this.color2 = '#385F73';
        this.color4 = '#385F73';
        this.color5 = '#385F73';
        this.ulrExcel = '/api/mplImportupdate';
      } else if (e == 4) {
        this.color4 = 'blue';
        this.color1 = '#385F73';
        this.color3 = '#385F73';
        this.color2 = '#385F73';
        this.color5 = '#385F73';
        this.ulrExcel = '/api/mplImportsend';
      } else {
        this.color5 = 'blue';
        this.color1 = '#385F73';
        this.color3 = '#385F73';
        this.color4 = '#385F73';
        this.color2 = '#385F73';
        this.ulrExcel = '/api/mplOk';
      }
      this.upload = true;
    },
    uploadMPL() {
      let formData = new FormData();
      formData.append('file', this.files);
      // formData.append('tbn', this.tbn);
      this.files = [];
      this.$axios
        .post(this.$store.state.backend_url + this.ulrExcel, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        .then((res) => {
          this.files = null;
          this.errordata = res.data;
          if (res.data) {
            this.errorvehicle = res.data.filter((v) => {
              return v.error == 1;
            });
            this.errordetail = res.data.filter((v) => {
              return v.error == 2;
            });
            this.errororder = res.data.filter((v) => {
              return v.error == 3;
            });
            this.errororuser = res.data.filter((v) => {
              return v.error == 4;
            });
            this.errororerror = res.data.filter((v) => {
              return v.error == 5;
            });
            this.errormodal = true;
            console.log(this.errorvehicle);
            console.log(this.errordetail);
            console.log(this.errororder);
          }

          if (!res.data) {
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
          }
        });
    },
  },
  mounted() {
    document.title = this.$t('main_page');
  },
};
</script>
<style scoped>
.fullHeight {
  height: calc(100% - 0px);
}
.home_card {
  box-shadow: none !important;
}
.textEllipsis {
  display: block;
  display: -webkit-box;
  max-width: 100%;
  height: 69px;
  margin: 0 auto;
  font-size: 18px;
  line-height: 1.4;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
