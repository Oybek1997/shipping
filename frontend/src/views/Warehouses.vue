<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        {{ $t('Warehouses') }}

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
        <v-btn
          @click="newDetail()"
          style="background-color:rgb(51, 122, 183); color: white"
          class="ml-8"
        >
          Ombor qo'shish
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
        max-width="30%"
        @keydown.esc="DetailModal = false"
      >
        <v-card>
          <v-card-title>
            <span class="headline">{{ $t('Ombor qo`shish') }}</span>
            <v-spacer></v-spacer>
            <v-btn color="red" x-small fab class @click="DetailModal = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col class="pt-4" cols="12">
                  <label>{{ $t('Nomi') }}</label>
                  <v-text-field v-model="form.name" dense></v-text-field>
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
// const moment = require("moment");
// import moment from 'moment';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      loading: false,
      details: [],
      search: '',
      empsearch: '',
      DetailModal: false,
      form: {},
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
        { text: this.$t('Name'), value: 'name', sortable: false },

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
    getDetailList() {
      this.loading = true;
      this.$axios
        .post(this.$store.state.backend_url + '/api/getWarehouses', {
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
        name: '',
        // source: '',
      };
    },
    editDetail(item) {
      this.DetailModal = true;
      this.form = Object.assign({}, item);
    },
    save() {
      this.$axios
        .post(
          this.$store.state.backend_url + '/api/warehouses/update',
          this.form
        )
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
              this.$store.state.backend_url +
                '/api/warehouses/delete/' +
                item.id
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
