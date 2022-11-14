<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        {{ $t('user.logs') }}
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="search"
          single-line
          hide-details
          clearable
          @keyup.native.enter="getUserLogs"
          outlined
          dense
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="userlogs"
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
          itemsPerPageOptions: [20, 50, 100],
          showFirstLastPage: true,
        }"
        @update:page="updatePage"
        @update:items-per-page="updatePerPage"
      >
        <template v-slot:item.id="{ item }">{{
          userlogs.map((v) => v.id).indexOf(item.id) + from
        }}</template>
        <template v-slot:item.fullname="{ item }"
          >{{ item.log_by.name }}
        </template>
        <template v-slot:item.fullinfo="{ item }"
          >{{ item.operation }} {{ item.user_device_type }}
          {{ item.user_browser }}
        </template>
        <!-- <template v-slot:item.request="{ item }">{{ item.request }} </template> -->
        <template v-slot:item.fullAction="{ item }"
          >{{ item.control }}
          <span class="font-weight-black">
            {{ item.request }}
          </span>
          {{ item.act }}
        </template>
      </v-data-table>
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
import moment from 'moment';
export default {
  data() {
    return {
      loading: false,
      userlogs: [],
      search: '',
      dataTableOptions: {
        page: 1,
        itemsPerPage: 20,
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
        { text: this.$t('user.username'), value: 'fullname', sortable: false },
        {
          text: this.$t('user.controller'),
          value: 'fullAction',
          sortable: false,
        },
        { text: 'IP', value: 'user_ip', sortable: false },
        { text: this.$t('user.system'), value: 'fullinfo', sortable: false },

        {
          text: this.$t('user.logtime'),
          value: 'created_at',
          sortable: false,
          width: '110px',
        },
      ];
    },
    screenHeight() {
      return window.innerHeight - 210;
    },
  },
  methods: {
    getUserLogs() {
      this.loading = true;
      this.$axios
        .post(this.$store.state.backend_url + '/api/user/logs', {
          pagination: this.dataTableOptions,
          search: this.search,
        })
        .then((res) => {
          // console.log(res);
          if (res.data == '403') {
            this.$router.push('/403');
          } else {
            this.loading = false;
            this.server_items_length = res.data.total;
            this.from = res.data.from;
            this.userlogs = res.data.data;
            // console.log(this.mpl);
            this.userlogs = this.userlogs.map((v) => {
              v.crt = v.created_at
                ? moment(v.created_at).format('DD.MM.YYYY')
                : '';
              if (v.controller == 'UserController') {
                v.control = 'Foydalanuvchilar sahifasida';
              } else if (v.controller == 'UserLogController') {
                v.control = 'Foydalanuvchilar Loglari sahifasida';
              } else if (v.controller == 'TestController') {
                v.control = 'Excel sahifasida';
              }
              if (v.action == 'index' || v.action == 'show') {
                v.act = 'ro`yxatni ko`rdi';
              } else if (v.action == 'getFile') {
                v.act = 'detal haqida ma`lumot oldi';
              } else if (v.action == 'downloadFile') {
                v.act = 'chizma yuklab oldi';
              } else if (v.action == 'mplImport') {
                v.act = 'yangi Excel yukladi';
              }
              const requestWord = 'partnum';
              const requestWordView = 'pagination';
              const requestDownload = 'path';
              if (v.request_json.includes(requestWord)) {
                const requestIndex = v.request_json.indexOf(requestWord); // 8
                const requestlength = requestWord.length + 3; // 7
                v.request = v.request_json.slice(
                  requestIndex + requestlength,
                  -2
                );
              } else if (v.request_json.includes(requestWordView)) {
                v.request = '';
              } else if (v.request_json.includes(requestDownload)) {
                const requestIndex = v.request_json.indexOf(requestDownload); // 8
                const requestlength = requestDownload.length + 3; // 7
                v.request = v.request_json.slice(
                  requestIndex + requestlength,
                  -2
                );
              }

              return v;
            });
          }

          // console.log(this.mpl);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    updatePage() {
      this.getUserLogs();
    },

    updatePerPage() {
      this.getUserLogs();
    },
  },
  mounted() {
    this.getUserLogs();
    document.title = this.$t('user.logs');
    // this.downloadPart();
    // this.getAllFile();
  },
};
</script>
<style></style>
