<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        {{ $t('Hodimlar') }}
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="search"
          single-line
          hide-details
          outlined
          dense
        ></v-text-field>
        <v-btn
          @click="newUser()"
          style="background-color:rgb(51, 122, 183); color: white"
          class="ml-8"
        >
          Hodim qo'shish
        </v-btn>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="users"
        :items-per-page="50"
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
          users.map((v) => v.id).indexOf(item.id) + 1
        }}</template>
        <template v-slot:item.otdel="{ item }">
          <div v-if="item.otdel == 1">Supply Chain</div>
          <div v-if="item.otdel == 2">Sifat</div>
          <div v-if="item.otdel == 3">Maxsus</div>
        </template>
        <template v-slot:item.icons="{ item }">
          <v-icon color="primary" @click="editEmployee(item)"
            >mdi-pencil sa</v-icon
          >
          <v-icon color="error" @click="deleteUser(item)">mdi-delete</v-icon>
        </template>
      </v-data-table>
      <v-dialog
        v-model="UserModal"
        persistent
        max-width="450px"
        @keydown.esc="UserModal = false"
      >
        <v-card>
          <v-card-title>
            <span class="headline">{{ $t('Hodim qo`shish') }}</span>
            <v-spacer></v-spacer>
            <v-btn color="red" x-small fab class @click="UserModal = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('Tabel raqami') }}</label>
                  <v-text-field v-model="form.tabno" dense></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('Ism Sharifi') }}</label>
                  <v-text-field v-model="form.fio" dense></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <!-- <label>{{ $t('user.role') }}</label> -->
                  <v-select
                    :items="roles"
                    required
                    v-model="form.otdel"
                    label="Rolni tanlang"
                  ></v-select>
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
    </v-card>
  </div>
</template>
<script>
import Swal from 'sweetalert2';
export default {
  data() {
    return {
      Loading: false,
      UserModal: false,
      UserTitle: '',
      users: [],
      search: '',
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
        { text: 'Tr', value: 'id' },
        { text: this.$t('Ism Sharifi'), value: 'fio', sortable: false },
        { text: this.$t('Tabel raqami'), value: 'tabno', sortable: false },
        { text: this.$t('Bo`lim'), value: 'otdel', sortable: false },
        {
          text: 'Amallar',
          align: 'center',
          value: 'icons',
          sortable: false,
          width: 80,
        },
      ];
    },
    roles() {
      return [
        { text: 'Supply chain', value: '1', sortable: false },
        { text: 'Sifat', value: '2', sortable: false },
        { text: 'Maxsus', value: '3', sortable: false },
      ];
    },
  },
  methods: {
    newUser() {
      this.UserModal = true;
      this.UserTitle = 'ADD User';
      this.form = {
        tabno: '',
        fio: '',
        otdel: '',
      };
    },
    editEmployee(item) {
      this.UserModal = true;
      this.form = Object.assign({}, item);
    },
    deleteUser(item) {
      Swal.fire({
        title: this.$t('O`chirishni istaysizmi?'),
        text: this.$t('Bu amalni ortga qaytarib bo`lmaydi'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: this.$t('O`chirish'),
      }).then((result) => {
        if (result.value) {
          this.$axios
            .delete(
              this.$store.state.backend_url + '/api/employees/delete/' + item.id
            )
            .then((res) => {
              console.log(res);
              this.getUserlist();
              Swal.fire(
                "O'chirildi!",
                this.$t('Ma`lumotlar omboridan o`chirildi'),
                'success'
              );
            })
            .catch((err) => {
              Swal.fire({
                icon: 'error',
                title: this.$t('Xatolik'),
                text: this.$t('Xatolik yuz berdi'),
                //footer: "<a href>Why do I have this issue?</a>"
              });
              console.log(err);
            });
        }
      });
    },
    save() {
      if (this.form.otdel) {
        this.$axios
          .post(
            this.$store.state.backend_url + '/api/employees/update',
            this.form
          )
          .then(() => {
            this.getUserlist();
            this.UserModal = false;
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
              title: this.$t('Muvaffaqqiyatli qo`shildi'),
            });
          });
      } else {
        alert("Barcha maydon to'ldirilishi shart");
      }
    },
    getUserlist() {
      this.Loading = true;
      this.$axios
        .post(this.$store.state.backend_url + '/api/getEmployee', {
          pagination: this.dataTableOptions,
        })
        .then((res) => {
          this.users = res.data.data;
          this.server_items_length = res.data.total;
          this.from = res.data.from;
          this.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          this.loading = false;
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
  },
  mounted() {
    this.getUserlist();
    document.title = this.$t('user.index');
  },
};
</script>
<style>
.text-start {
  border: 1px solid #ddd;
}
.v-data-table-header th {
  background-color: rgb(51, 122, 183) !important;
  color: white !important;
}
/*.v-data-table-header {*/
/*    color: white;*/
/*}*/
</style>
