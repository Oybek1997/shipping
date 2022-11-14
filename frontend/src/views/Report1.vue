<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        {{ $t('Detallar soni bo`yicha hisobot') }}

        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          :label="$t('search')"
          single-line
          hide-details
          clearable
          @keyup.native.enter="getVehicleList"
          outlined
          dense
        ></v-text-field>


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
                    :name="'Detallar_ruyxati.xls'"
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

      </v-card-title>
      <table
        :style="{ height: screenHeight + 'px' }"
        class="tablestyle"
        border="1"
        v-if="items.length > 0"
      >
        <thead>
          <tr>
            <th>
              #
            </th>
            <th>
              Model
            </th>
            <th>
              Vin
            </th>
            <th>
              Detallar soni
            </th>
            <th colspan="3" v-for="(i, k) in items[0].details" :key="k">
              Detal {{ k + 1 }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, key) in items" :key="key">
            <td class="tabborder">{{ key + from }}</td>
            <td class="tabborder">{{ item.modelname }}</td>
            <td class="tabborder">{{ item.vin }}</td>
            <td class="tabborder">{{ item.count }}</td>
            <template v-for="(i, k) in item.details">
              <td
                class="tabborder"
                :key="k + key + 'aa'"
                style="font-weight:bold;"
              >
                {{ i.part }}
              </td>
              <td class="tabborder" :key="k + key + 'bb'">{{ i.part_name }}</td>
              <!-- <td class="tabborder" :key="k + key + 'cc'" v-if="i.masulemp">
                {{ i.masulemp.fio }}
              </td> -->
              <td class="tabborder" :key="k + key + 'dd'">{{ i.suplier }}</td>
            </template>
            <template
              v-for="(i, k) in new Array(
                items[0].details.length - item.details.length
              )"
            >
              <td class="tabborder" :key="k + 'a'"></td>
              <td class="tabborder" :key="k + 'b'"></td>
              <td class="tabborder" :key="k + 'c'"></td>
              <!-- <td class="tabborder" :key="k + 'd'"></td> -->
            </template>
          </tr>
        </tbody>
      </table>
      <v-row class="mt-1">
        <v-col cols="7"></v-col>
        <v-col cols="1">
          <v-select
            v-model="pagination.per_page"
            :items="[20, 50, 100, 200]"
            outlined
            dense
            hide-details
            @change="perPageUpdate"
          >
          </v-select>
        </v-col>
        <v-col>
          <v-btn :disabled="arrow1" class="mx-1" @click="firstPage"
            ><v-icon>mdi-arrow-collapse-left</v-icon></v-btn
          >
          <v-btn :disabled="arrow2" class="mx-1" @click="prevPage"
            ><v-icon>mdi-arrow-left</v-icon></v-btn
          >
          {{ from }}-{{ to }} of {{ total }}
          <v-btn :disabled="arrow3" class="mx-1" @click="nextPage"
            ><v-icon>mdi-arrow-right</v-icon></v-btn
          >
          <v-btn :disabled="arrow4" class="mx-1" @click="lastPage"
            ><v-icon>mdi-arrow-collapse-right</v-icon></v-btn
          >
        </v-col>
      </v-row>
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
// import Swal from "sweetalert2";

import Vue from "vue";
import JsonExcel from "vue-json-excel";
import {default as axios} from "axios";

Vue.component("downloadExcel", JsonExcel);


export default {
  data() {
    return {
      loading: false,
      items: [],
      search: '',
      VehicleModal: false,
      pagination: {
        page: 1,
        per_page: 20,
      },
      items_count: null,
      arrow1: true,
      arrow2: true,
      arrow3: true,
      arrow4: true,
      last_page: null,
      from: 0,
      total: 0,
      to: 0,

      downloadExcel: false,
      inventory_excel: [],

      filter: {
        model: null,
        vin: null,
        count: null,
      },
    };
  },
  computed: {
    screenHeight() {
      return window.innerHeight - 230;
    },
  },
  methods: {
    getVehicleList() {
      this.loading = true;
      this.$axios
        .post(this.$store.state.backend_url + '/api/report-count', {
          pagination: this.pagination,
          search: this.search,
        })
        .then((res) => {
          this.items = res.data.data;
          let qoldiq = res.data.total % res.data.per_page ? 1 : 0;
          this.items_count =
            parseInt(res.data.total / res.data.per_page) + qoldiq;

          this.pagination.page = res.data.current_page;
          this.last_page = res.data.last_page;
          this.from = res.data.from;
          this.total = res.data.total;
          this.to = res.data.to;

          if (res.data.next_page_url && res.data.last_page_url) {
            this.arrow3 = false;
            this.arrow4 = false;
          } else {
            this.arrow3 = true;
            this.arrow4 = true;
          }
          if (res.data.prev_page_url) {
            this.arrow1 = false;
            this.arrow2 = false;
          } else {
            this.arrow1 = true;
            this.arrow2 = true;
          }
          this.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          this.loading = false;
        });
    },
    nextPage() {
      this.pagination.page += 1;
      this.updatePage();
    },
    prevPage() {
      this.pagination.page -= 1;
      this.updatePage();
    },
    lastPage() {
      this.pagination.page = this.last_page;
      this.updatePage();
    },
    firstPage() {
      this.pagination.page = 1;
      this.updatePage();
    },
    perPageUpdate() {
      this.pagination.page = 1;
      this.updatePage();
    },
    editVehicle(item) {
      this.VehicleModal = true;
      this.form = Object.assign({}, item);
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
          .post(this.$store.state.backend_url + "/api/report1/get-excel", {
            filter: this.filter,
            type: 1,
            pagination: {
              page: page,
              itemsPerPage: 1000,
            },
          })



          .then((response) => {
            response.data.map((v, index) => {
              // console.log(v[0])
              new_array.push({
                "№": index + page,
                Model:v[0],
                Vin:v[1],
                Count:v[2],
                Detal1:v[3],
                PartName1:v[4],
                Supplier1:v[5],
                Detal2: v[6],
                PartName2:v[7],
                Supplier2:v[8],
                Detal3: v[9],
                PartName3:v[10],
                Supplier3: v[11],
                Detal4: v[12],
                PartName4: v[13],
                Supplier4: v[14],
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
    this.getVehicleList();
    document.title = this.$t('drawings');
  },
};
</script>
<style scoped>
.itemWidth {
  width: 15%;
}
.tablestyle {
  width: 98%;
  margin: 10px;
  border-collapse: collapse;
  overflow: auto;
  display: block;
}
.dialogHeight {
  max-height: 80%;
}
table > thead > tr > th {
  padding: 10px;
  position: sticky;
  background-color: white;
  top: 0;
  z-index: 1;
}
table > tbody > tr > td {
  padding: 5px;
}
.tabborder {
  white-space: nowrap;
}
.rightborder:not(:last-child) {
  border-right: 1px solid;
}
</style>
