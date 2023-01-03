<template>
  <v-row class="logo-back fill-height justify-center">
    <v-col
        class="text-center"
        cols="5"
        style="max-width:440px;min-width:400px;margin-top:5%"
    >
      <v-card :elevation="10">
        <v-col>
          <div class style="padding: 25px 10px 0 10px;">
            <img
                src="/logo.jpg"
                alt="UzAuto logo"
                width="190px"
            />

          </div>
          <div>
            <v-form @keyup.native.enter="login" style="padding: 15px">
              <v-text-field
                  v-model="username"
                  color="#203d5b"
                  :placeholder="$t('username')"
                  type="text"
                  class="custom-placeholer-color"
                  outlined
                  dense
                  autocomplete="off"
              ></v-text-field>
              <v-text-field
                  v-model="password"
                  color="#203d5b"
                  :placeholder="$t('password')"
                  type="password"
                  outlined
                  dense
                  autocomplete="off"
              ></v-text-field>
              <v-alert
                  v-if="errorAlert && this.username != '' && this.password != ''"
                  dense
                  text
                  outlined
                  type="error"
                  icon="mdi-alert-outline"
                  class="caption py-1"
              >{{ $t('incorrect_login') }}</v-alert
              >
              <v-col cols="6" class="my-0 py-0">
                <v-checkbox
                    v-model="rememberMe"
                    cl
                    :label="$t('rememberMe')"
                ></v-checkbox>
              </v-col>
              <v-btn
                  block
                  color="rgb(32, 61, 91)"
                  @click="login"
                  class="col-12"
                  dark
              >
                {{ $t('login') }}
                <v-progress-circular
                    v-if="loader"
                    indeterminate
                    :width="3"
                    :size="18"
                ></v-progress-circular>
              </v-btn>
              <!-- <a href="/file/telejka.pptx" class="text-decoration">
                <v-btn outlined depressed small class="mt-6">
                  <v-icon left>mdi-arrow-down-circle-outline</v-icon>Qo'llanma
                </v-btn>
              </a>-->
            </v-form>
          </div>
        </v-col>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
// import Swal from "sweetalert2";
const axios = require('axios').default;
import Cookies from 'js-cookie';
export default {
  data() {
    return {
      username: '',
      password: '',
      rememberMe: false,
      loader: null,
      errorAlert: false,
    };
  },
  methods: {
    login() {
      this.loader = !this.loader;
      axios
          .post(this.$store.state.backend_url + '/oauth/token', {
            grant_type: 'password',
            client_id: '2',
            client_secret: '6i4Y0T5QFICTuxUo0052xMPDN6QEDbuGkyRdhcHl',
            username: this.username,
            password: this.password,
            // client_id: "7",
            // client_secret: "op1mP1RlFCj6PMlgyzar9lvw7Yy1pE3OJbodBSL9",
            // client_id: "5",
            // client_secret: "CZC1cQDoupNtr0J7oX8f4SAuSKZkzCn5BxZZo5aL",
          })
          .then((res) => {
            Cookies.set(
                'access_token',
                res.data.token_type + ' ' + res.data.access_token
            );

            axios.defaults.headers.common = {
              Accept: 'application/json',
              'Content-Type': 'application/json',
              Authorization: res.data.token_type + ' ' + res.data.access_token,
            };
            axios
                .get(this.$store.state.backend_url + '/api/users/show')
                .then((data) => {
                  // let permissions = data.data.roles
                  //   .reduce(
                  //     (accumulator, currentValue) =>
                  //       accumulator.concat(currentValue.permissions),
                  //     []
                  //   )
                  //   .map((v) => v.name);
                  this.$store.dispatch('setUser', data.data);
                  // this.$store.dispatch("setPermissions", permissions);
                  this.$router.push('/');
                })
                .catch((e) => {
                  console.error(e);
                  this.loading = false;
                });
          })
          .catch((error) => {
            this.errorAlert = true;
            console.log(error);
            this.loading = false;
          });
    },
  },
};
</script>
<style scoped>
.text-decoration {
  text-decoration: none;
}
v-text-field__slot {
  color: red !important;
}
</style>
