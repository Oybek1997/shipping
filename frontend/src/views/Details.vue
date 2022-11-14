<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        {{ $t('Details') }}

        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          :label="$t('search')"
          single-line
          hide-details
          clearable
          @keyup.native.enter="getDetailList"
          outlined
          dense
        ></v-text-field>
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
        <v-btn
          @click="newDetail()"
          style="background-color:rgb(51, 122, 183); color: white"
          class="ml-8"
        >
          Detal qo'shish
        </v-btn>

        <v-btn
            outlined
            x-small
            fab
            @click="
            getDetailExcel(1);
            inventory_excel = [];
          "
            class="mr-2"
        >
          <v-icon>mdi-file-excel-outline</v-icon>
        </v-btn>

      </v-card-title>












      <v-data-table
        :headers="headers"
        :items="details"
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
          details.map((v) => v.id).indexOf(item.id) + from
        }}</template>

        <template v-slot:item.options="{ item }"
          ><v-icon color="primary" @click="editDetail(item)"
            >mdi-pencil sa</v-icon
          >
          <v-icon color="error" @click="deleteDetail(item)">mdi-delete</v-icon>
        </template>
      </v-data-table>

      <v-dialog
        v-model="DetailModal"
        persistent
        max-width="50%"
        @keydown.esc="DetailModal = false"
      >
        <v-card>
          <v-card-title>
            <span class="headline">{{ $t('Edit Detail') }}</span>
            <v-spacer></v-spacer>
            <v-btn color="red" x-small fab class @click="DetailModal = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('PartNumber') }}</label>
                  <v-text-field v-model="form.part" dense></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('Part Name') }}</label>
                  <v-text-field v-model="form.part_name" dense></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('Supplier') }}</label>
                  <v-text-field v-model="form.suplier" dense></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('Masul') }}</label>
                  <v-autocomplete
                    v-model="form.masul_emp"
                    :loading="loading"
                    :items="employees"
                    :search-input.sync="empsearch"
                    cache-items
                    hide-details
                    item-text="name"
                    item-value="id"
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
      <v-dialog v-model="downloadExcel" hide-overlay persistent width="300">
        <v-card>
          <v-card-text class="py-1 px-3">
            <v-btn
                color="success"
                class="mx-10"
                @click="downloadExcel = false"
                text
            >
              <download-excel
                  :data="inventory_excel"
                  :name="'Inv_ruyxati.xls'"
              >
                <span style="color: #4caf50">{{ $t("download") }}</span>
                <v-icon color="success" height="20">mdi-download</v-icon>
              </download-excel>
            </v-btn>
            <v-btn class color="error" @click="downloadExcel = false" icon>
              <v-icon color="error" height="20">mdi-close</v-icon>
            </v-btn>
          </v-card-text>
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
// import moment from 'moment';
const axios = require("axios").default;
import Swal from 'sweetalert2';
// import Template from "../document/Template.vue";


export default {
  // components: { Template },

  data() {
    return {
      loading: false,
      details: [],
      files: null,
      search: '',
      empsearch: '',
      employees: [],
      DetailModal: false,
      form: {},
      downloadExcel: false,
      inventory_excel: [],
      dataTableOptions: {
        page: 1,
        itemsPerPage: 50,
      },
      page: 1,
      server_items_length: -1,
      from: 0,
    };
  },
  computed: {
    headers() {
      return [
        { text: this.$t('tr'), value: 'id', sortable: false },
        { text: this.$t('Part'), value: 'part', sortable: false },
        {
          text: this.$t('Partname'),
          value: 'part_name',
          sortable: false,
        },
        { text: this.$t('Supplier'), value: 'suplier', sortable: false },
        { text: this.$t('Masul'), value: 'masulemp.name', sortable: false },
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
    uploadMPL() {
      let formData = new FormData();
      formData.append('file', this.files);
      this.files = [];
      this.$axios
        .post(this.$store.state.backend_url + '/api/details', formData, {
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
    getDetailList() {
      this.loading = true;
      this.$axios
        .post(this.$store.state.backend_url + '/api/getDetail', {
          pagination: this.dataTableOptions,
          search: this.search,
        })
        .then((res) => {
          this.server_items_length = res.data.total;
          this.from = res.data.from;
          this.details = res.data.data;
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
        .catch(function(error) {
          console.log(error);
          this.loading = false;
        });
    },
    newDetail() {
      this.DetailModal = true;
      this.getUsers();
      this.form = {
        id: Date.now(),
        part: '',
        part_name: '',
        masul_emp: '',
        // source: '',
      };
    },
    editDetail(item) {
      this.DetailModal = true;
      this.form = Object.assign({}, item);
    },
    save() {
      this.$axios
        .post(this.$store.state.backend_url + '/api/details/update', this.form)
        .then(() => {
          this.getDetailList();
          this.employees = [];
          this.DetailModal = false;
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
    deleteDetail(item) {
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
              this.$store.state.backend_url + '/api/details/delete/' + item.id
            )
            .then((res) => {
              console.log(res);
              this.getDetailList();
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
    getUsers() {
      this.$axios
        .get(this.$store.state.backend_url + '/api/users')
        .then((res) => {
          this.employees = res.data.users;
        });
    },
    updatePage() {
      this.getDetailList();
    },
    screenWidth() {
      return window.innerWidth;
    },
    updatePerPage() {
      this.getDetailList();
    },



    getDetailExcel(page) {
      let new_array = [];
      this.loading = true;
      axios
          .post(this.$store.state.backend_url + "/api/details/get-excel", {
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
                "№": index + page,
                Part: v.Part,
                Partname: v.PartName,
                Supplier: v.Supplier,
                Masul: v.Masul,
              });
              // console.log("This is :",v)
            });
            // new_array = response.data.data;

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


  },
  mounted() {
    this.getDetailList();
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
