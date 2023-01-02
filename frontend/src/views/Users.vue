<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        {{ $t('user.index') }}
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
          @click="newSimpleUser()"
          style="background-color:rgb(51, 122, 183); color: white"
          class="ml-8"
        >
          User qo'shish
        </v-btn>
        <v-btn
          @click="newUser()"
          style="background-color:rgb(51, 122, 183); color: white"
          class="ml-8"
        >
          AD User qo'shish
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
      >
        <template v-slot:item.id="{ item }"
          >{{ users.map((v) => v.id).indexOf(item.id) + 1 }}
        </template>
        <template v-slot:item.icons="{ item }">
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
            <span class="headline">{{ $t('user.add') }}</span>
            <v-spacer></v-spacer>
            <v-btn color="red" x-small fab class @click="UserModal = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('user.tbn') }}</label>
                  <v-text-field
                    v-model="form.tbnumber"
                    dense
                    @change="usertbn"
                  ></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <!-- <label>{{ $t('user.role') }}</label> -->
                  <v-select
                    :items="roles"
                    required
                    item-text="name"
                    item-value="id"
                    v-model="form.role"
                    label="Rolni tanlang"
                  ></v-select>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('user.username') }}</label>
                  <v-text-field
                    v-model="form.username"
                    disabled
                    dense
                  ></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('user.name') }}</label>
                  <v-text-field
                    v-model="form.name"
                    disabled
                    dense
                  ></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('user.email') }}</label>
                  <v-text-field
                    v-model="form.email"
                    disabled
                    dense
                    :error-messages="errors['email'] ? errors['email'] : []"
                  ></v-text-field>
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

      <v-dialog
        v-model="UserSimpleModal"
        persistent
        max-width="450px"
        @keydown.esc="UserSimpleModal = false"
      >
        <v-card>
          <v-card-title>
            <span class="headline">{{ $t('user.add') }}</span>
            <v-spacer></v-spacer>
            <v-btn
              color="red"
              x-small
              fab
              class
              @click="UserSimpleModal = false"
            >
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('user.tbn') }}</label>
                  <v-text-field v-model="form.tbnumber" dense></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <!-- <label>{{ $t('user.role') }}</label> -->
                  <v-select
                    :items="roles"
                    required
                    v-model="form.role"
                    item-text="name"
                    item-value="id"
                    label="Rolni tanlang"
                  ></v-select>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('user.username') }}</label>
                  <v-text-field v-model="form.username" dense></v-text-field>
                </v-col>
                <v-col class="pt-0" cols="12">
                  <label>{{ $t('user.name') }}</label>
                  <v-text-field v-model="form.name" dense></v-text-field>
                </v-col>
                <v-col ref="form" class="pt-0" cols="12">
                  <label>{{ $t('user.email') }}</label>
                  <v-text-field
                    v-model="form.email"
                    dense
                    :error-messages="errors['email'] ? errors['email'] : []"
                    :rules="emailRules"
                  ></v-text-field>
                </v-col>

                <v-col class="pt-0" cols="12">
                  <label>{{ $t('user.password') }}</label>
                  <v-text-field
                    type="password"
                    v-model="form.password"
                    dense
                  ></v-text-field>
                </v-col>

                <v-col class="pt-0" cols="12">
                  <label>{{ $t('user.c_password') }}</label>
                  <v-text-field
                    type="password"
                    v-model="form.c_password"
                    dense
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions class="pt-0">
            <v-spacer></v-spacer>
            <v-btn color="green" dark @click="simpleSave">{{
              $t('save')
            }}</v-btn>
            <!--                        <v-btn color="red darken-1" dark @click="onClickOutside">{{ $t('close') }}</v-btn>-->
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog
        v-model="UserEditModal"
        persistent
        max-width="450px"
        @keydown.esc="UserEditModal = false"
      >
        <v-card v-if="form.name">
          <v-card-title>
            <span class="headline">{{ form.name }}</span>
            <v-spacer></v-spacer>
            <v-btn color="red" x-small fab class @click="UserEditModal = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col class="pt-0" cols="12">
                  <!-- <label>{{ $t('user.role') }}</label> -->
                  <v-select
                    :items="roles"
                    required
                    v-model="form.role"
                    item-text="name"
                    item-value="id"
                    label="Roleni tanlang"
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
// const moment = require("moment");
import moment from 'moment';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      Loading: false,
      UserModal: false,
      UserSimpleModal: false,
      UserEditModal: false,
      UserTitle: '',
      users: [],
      search: '',
      form: {},
      email: '',
      errors: [],
      roles: null,
      emailRules: [
        (v) => !!v || this.$t('user.email_required'),
        //v => /.+@.+\..+/.test(v) || this.$t('user.email_valid'),
        (v) =>
          (!!v &&
            v.length > 0 &&
            /^([a-zA-Z0-9_\-.]+)@([a-zA-Z0-9_\-.]+)\.([a-zA-Z]{2,5})$/.test(
              v
            )) ||
          'Invalid e-mail.',
      ],
    };
  },
  computed: {
    headers() {
      return [
        { text: 'Tr', value: 'id' },
        { text: this.$t('user.name'), value: 'name', sortable: false },
        { text: this.$t('user.username'), value: 'username', sortable: false },
        { text: this.$t('user.email'), value: 'email', sortable: false },
        { text: this.$t('Role'), value: 'role.name', sortable: false },
        { text: this.$t('user.created'), value: 'crt', sortable: false },
        { text: this.$t('user.updated'), value: 'upd', sortable: false },
        {
          text: 'Amallar',
          align: 'center',
          value: 'icons',
          sortable: false,
          width: 80,
        },
      ];
    },
  },
  methods: {
    newUser() {
      this.UserModal = true;
      this.UserTitle = 'ADD User';
      this.errors = [];
      this.form = {
        id: Date.now(),
        name: '',
        username: '',
        email: '',
        tbnumber: '',
        password: '',
        c_password: '',
      };
    },
    newSimpleUser() {
      this.UserSimpleModal = true;
      console.log("simple")
      this.UserTitle = 'ADD Simple User';
      this.errors = [];
      this.form = {
        id: Date.now(),
        name: '',
        username: '',
        email: '',
        tbnumber: '',
        password: '',
        c_password: '',
      };
    },


    deleteUser(item) {
      console.log(item.id);
      if (item.id == 18) {
        alert("Siz Super Adminni o'chira olmaysiz!");
      } else {
        this.$axios
          .delete(
            this.$store.state.backend_url + '/api/users/delete/' + item.id
          )
          .then((resp) => {
            console.log(resp);
            this.getUserlist();
          });
      }
    },
    usertbn() {
      this.$axios
        .post(
          this.$store.state.backend_url + '/api/getuser/' + this.form.tbnumber
        )
        .then((resp) => {
          this.form.email = resp.data.email;
          this.form.name = resp.data.name;
          this.form.username = resp.data.username;
          this.form.password = resp.data.password;
          this.form.c_password = resp.data.c_password;
        });
    },
    editUser(item) {
      this.UserEditModal = true;
      this.form = Object.assign({}, item);
      // this.editedUser = item;
      console.log(this.form);
    },
    save() {
      // if (this.$refs.form.validate()) {
      if (this.form.role) {
        console.log(this.form);
        this.$axios
          .post(this.$store.state.backend_url + '/api/users/update', this.form)
          .then(() => {
            this.getUserlist();
            this.UserModal = false;
            this.UserEditModal = false;
            this.roles = null;
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
      } else {
        alert("Barcha maydon to'ldirilishi shart");
      }
    },
    getRoles() {
      this.$axios
        .get(this.$store.state.backend_url + '/api/roles')
        .then((resp) => {
          this.roles = resp.data;
        });
    },
    simpleSave() {
      if (this.form.role) {
        this.$axios
          .post(
            this.$store.state.backend_url + '/api/users/usercreate',
            this.form
          )
          .then(() => {
            this.getUserlist();
            this.UserSimpleModal = false;
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
      } else {
        alert("Barcha maydon to'ldirilishi shart");
      }
    },

    getUserlist() {
      this.Loading = true;
      this.$axios
        .get(this.$store.state.backend_url + '/api/users')
        .then((res) => {
          this.users = res.data.users;
          this.users = this.users.map((v) => {
            v.crt = v.created_at
              ? moment(v.created_at).format('DD.MM.YYYY')
              : '';
            v.upd = v.updated_at
              ? moment(v.updated_at).format('DD.MM.YYYY')
              : '';
            return v;
          });
          this.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          this.loading = false;
        });
    },
  },
  mounted() {
    this.getUserlist();
    this.getRoles();
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
