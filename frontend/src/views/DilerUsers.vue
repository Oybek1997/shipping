<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        {{ $t('Diler Wins') }}
        <v-spacer></v-spacer>
        <v-btn
          @click="attachUser()"
          style="background-color: rgb(51, 122, 183); color: white"
          class="ml-8"
        >
          User biriktirish
        </v-btn>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="vehicles"
        :height="screenHeight"
        class="elevation-1 ma-1"
        :search="search"
        style="border: 1px solid #aaa"
        fixed-header
        single-expand
        :options.sync="dataTableOptions"
        item-key="id"
        :server-items-length="server_items_length"
        :disable-pagination="true"
        :footer-props="{
          itemsPerPageText: 'Sahifadagi yozuvlar soni',
          itemsPerPageOptions: [50, 100, 200],
          showFirstLastPage: true,
        }"
        @update:page="updatePage"
        @update:items-per-page="updatePerPage"
      >
        <template v-slot:item.id="{ item }">{{
          vehicles.map((v) => v.id).indexOf(item.id) + from
        }}</template>

        <template v-slot:item.options="{ item }"
          ><v-icon color="primary" @click="editVehicle(item)"
            >mdi-pencil sa</v-icon
          >
          <v-icon color="error" @click="deleteVehicle(item)">mdi-delete</v-icon>
        </template>
      </v-data-table>
      <v-dialog v-model="downloadExcel" hide-overlay persistent width="300">
        <v-card>
          <v-card-text class="py-1 px-3">
            <v-btn
              color="success"
              class="mx-10"
              @click="downloadExcel = false"
              text
            >
              <download-excel :data="inventory_excel" :name="'Inv_ruyxati.xls'">
                <span style="color: #4caf50">{{ $t('download') }}</span>
                <v-icon color="success" height="20">mdi-download</v-icon>
              </download-excel>
            </v-btn>
            <v-btn class color="error" @click="downloadExcel = false" icon>
              <v-icon color="error" height="20">mdi-close</v-icon>
            </v-btn>
          </v-card-text>
        </v-card>
      </v-dialog>
      <v-dialog
        v-model="AttachUserModal"
        persistent
        max-width="50%"
        @keydown.esc="AttachUserModal = false"
      >
        <v-card>
          <v-card-title>
            <span class="headline">{{ $t('User biriktirish') }}</span>
            <v-spacer></v-spacer>
            <v-btn
              color="red"
              x-small
              fab
              class
              @click="AttachUserModal = false"
            >
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col class="pt-0" cols="12">
                  <v-autocomplete
                    v-model="selectedDiller"
                    :items="dillersList"
                    outlined
                    dense
                    chips
                    item-value="id"
                    item-text="name"
                    small-chips
                    label="Ombor"
                    multiple
                  ></v-autocomplete>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <v-autocomplete
                    v-model="selectedUser"
                    :items="usersList"
                    item-value="id"
                    item-text="name"
                    outlined
                    dense
                    label="User"
                  ></v-autocomplete>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions class="pt-0">
            <v-spacer></v-spacer>
            <v-btn color="green" dark @click="save">{{ $t('save') }}</v-btn>
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
import Swal from 'sweetalert2';
let axios = require('axios').default;
export default {
  data() {
    return {
      loading: false,
      vehicles: [],
      search: '',
      AttachUserModal: false,
      form: {},
      dillersList: {},
      usersList: {},
      selectedDiller: [],
      selectedUser: [],
      inventory_excel: [],
      dataTableOptions: {
        page: 1,
        itemsPerPage: 50,
      },
      page: 1,
      server_items_length: -1,
      from: 0,
      downloadExcel: false,
    };
  },
  computed: {
    headers() {
      return [
        { text: this.$t('tr'), value: 'id', sortable: false },
        { text: this.$t('Diler Name'), value: 'diler.name', sortable: false },
        { text: this.$t('User Name'), value: 'user.name', sortable: false },
        {
          text: 'Amallar',
          align: 'center',
          value: 'options',
          sortable: false,
          width: 80,
        },
      ];
    },
    screenHeight() {
      return window.innerHeight - 210;
    },
  },
  methods: {
    getVehicleList() {
      this.loading = true;
      this.$axios
        .post(this.$store.state.backend_url + '/api/getDilerUser', {
          pagination: this.dataTableOptions,
          search: this.search,
        })
        .then((res) => {
          this.server_items_length = res.data.total;
          this.from = res.data.from;
          this.vehicles = res.data.data;
          //   this.mpl = this.mpl.map((v) => {
          //     v.crt = v.created_at
          //       ? moment(v.created_at).format('DD.MM.YYYY')
          //       : '';
          //     v.upd = v.updated_at
          //       ? moment(v.updated_at).format('DD.MM.YYYY')
          //       : '';
          //     return v;
          //   });
          this.loading = false;
        })
        .catch(function (error) {
          console.log(error);
          this.loading = false;
        });
    },
    getMainData() {
      this.loading = true;
      this.$axios
        .get(this.$store.state.backend_url + '/api/getMainData')
        .then((res) => {
          this.dillersList = res.data.dillers;
          this.usersList = res.data.users;
          // console.log(this.dillersList);
          this.loading = false;
        })
        .catch(function (error) {
          console.log(error);
          this.loading = false;
        });
    },
    attachUser() {
      this.AttachUserModal = true;
    },
    editVehicle(item) {
      this.VehicleModal = true;
      this.form = Object.assign({}, item);
    },
    save() {
      this.$axios
        .post(this.$store.state.backend_url + '/api/dillerUser/add', {
          dillers: this.selectedDiller,
          user: this.selectedUser,
        })
        .then(() => {
          this.getVehicleList();
          this.AttachUserModal = false;
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
    deleteVehicle(item) {
      Swal.fire({
        title: this.$t('swal_title'),
        text: this.$t('swal_text'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: this.$t('swal_delete'),
      }).then((result) => {
        if (result.value) {
          this.$axios
            .delete(
              this.$store.state.backend_url + '/api/vehicles/delete/' + item.id
            )
            .then((res) => {
              console.log(res);
              this.getVehicleList();
              Swal.fire("O'chirildi!", this.$t('swal_deleted'), 'success');
            })
            .catch((err) => {
              Swal.fire({
                icon: 'error',
                title: this.$t('swal_error_title'),
                text: this.$t('swal_error_text'),
                //footer: "<a href>Why do I have this issue?</a>"
              });
              console.log(err);
            });
        }
      });
    },
    updatePage() {
      this.getVehicleList();
    },
    screenWidth() {
      return window.innerWidth;
    },
    updatePerPage() {
      this.getVehicleList();
    },

    getDetailExcel(page) {
      let new_array = [];
      this.loading = true;
      axios
        .post(this.$store.state.backend_url + '/api/vehicles/get-excel', {
          filter: this.filter,
          type: 1,
          pagination: {
            page: page,
            itemsPerPage: 1000,
          },
        })
        .then((response) => {
          response.data.map((v, index) => {
            new_array.push({
              '№': index + page,
              Vin: v.Vin,
              Tabno: v.Tabno,
              Status: v.Status,
              Sector: v.Sector,
              Row: v.Row,
              Tcd_date: v.Tcd_date,
            });
          });
          this.inventory_excel = this.inventory_excel.concat(new_array);
          if (response.data.length == 1000) {
            this.getDetailExcel(++page);
          } else {
            this.loading = false;
            this.downloadExcel = true;
          }
        })
        .catch((error) => {
          console.log(error);
          this.loading = false;
        });
    },
    deleteFunction() {
      Swal.fire({
        title: this.$t('Delete'),
        text: this.$t('Delete Warning'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: this.$t('Delete All'),
      }).then((result) => {
        if (result.value) {
          this.$axios
            .post(this.$store.state.backend_url + '/api/delete-all')
            .then((res) => {
              console.log(res);
              this.getVehicleList();
              Swal.fire("O'chirildi!", this.$t('swal_deleted'), 'success');
            })
            .catch((err) => {
              Swal.fire({
                icon: 'error',
                title: this.$t('swal_error_title'),
                text: this.$t('swal_error_text'),
                //footer: "<a href>Why do I have this issue?</a>"
              });
              console.log(err);
            });
        }
      });
    },
  },
  mounted() {
    this.getVehicleList();
    this.getMainData();
    document.title = this.$t('drawings');
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
