<template>
  <div class="mx-1 mt-1">
    <v-card>
      <v-card-title>
        <v-row>
          <v-col>
            {{ $t("Label chiqarilgan VIN nomer va detallar ro'yhari") }}
          </v-col>
          <v-col xl="2" lg="3" md="4">
            <v-select
              v-model="modelType"
              :items="modelItems"
              :label="$t('Model')"
              dense
              outlined
              hide-details
              clearable
              @change="getVehicleList"
              append-icon="mdi-car"
            ></v-select
          ></v-col>
          <v-col xl="2" lg="4" md="4">
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify-plus"
              :label="$t('search')"
              hide-details
              clearable
              @keyup.native.enter="getVehicleList"
              outlined
              dense
            ></v-text-field
          ></v-col>
        </v-row>
      </v-card-title>
      <table
        :style="{ height: screenHeight + 'px' }"
        class="tablestyle"
        v-if="items.length > 0"
      >
        <thead style="width:100%">
          <tr>
            <th rowspan="2" style="width:50px;">
              #
            </th>
            <th rowspan="2" style="width:80px;">
              Model
            </th>
            <th rowspan="2" style="width:200px;">
              Vin
            </th>
            <th rowspan="2" style="width:50px;">
              Soni
            </th>
            <th rowspan="2" style="width:20px;">
              Color
            </th>
            <th rowspan="2" style="width:10px;">
              Amallar
            </th>
            <th colspan="5">
              Detal
            </th>
          </tr>
          <tr>
            <th style="width:10px;">#</th>
            <th style="width:120px;">Part nomer</th>
            <th style="width:100%;">Nomi</th>
            <th style="width:100%;">Mas'ul</th>
            <!-- <th style="width:80px;">Amallar</th> -->
          </tr>
        </thead>
        <tbody v-for="(item, key) in items" :key="key" style="width:100%;">
          <tr v-for="(i, k) in item.details" :key="k">
            <td class="tabborder" :rowspan="item.details.length" v-if="k == 0">
              {{ key + from }}
            </td>
            <td class="tabborder" :rowspan="item.details.length" v-if="k == 0">
              {{ item.modelname }}
            </td>
            <td class="tabborder" :rowspan="item.details.length" v-if="k == 0">
              {{ item.vin }}
            </td>
            <td
              class="tabborder text-right"
              :rowspan="item.details.length"
              v-if="k == 0"
            >
              {{ item.count }}
            </td>
            <td class="tabborder" :rowspan="item.details.length" v-if="k == 0">
              {{ item.color == 2 ? 'Sariq' : 'Oq' }}
            </td>
            <td
              class="tabborderin"
              :rowspan="item.details.length"
              v-if="k == 0"
            >
              <!-- <v-btn
                v-if="
                  (user.role.name == 'sifat' && item.ok_by == null) ||
                    (user.role.name == 'admin' && item.ok_by == null)
                "
                class="mb-2"
                outlined
                color="#78909C"
                @click="okVin(item)"
                title="Ok qilish"
              >
                <v-icon>mdi-check-bold</v-icon> </v-btn
              > -->
              <!-- <br />
              <v-btn
                class="my-2"
                outlined
                color="#78909C"
                @click="addDetail(item)"
                title="Detal qo'shish"
              >
                <v-icon>mdi-plus</v-icon> </v-btn
              ><br /> -->
              <v-btn
                v-if="user.role.name == 'supply' || user.role.name == 'admin'"
                class="mt-2"
                outlined
                color="#78909C"
                @click="printVin(item)"
                title="Label pechat qilish"
              >
                <v-icon>mdi-printer-outline</v-icon> </v-btn
              ><br />
            </td>
            <td class="tabborderin">
              {{ k + 1 }}
            </td>
            <td class="tabborderin">
              {{ i.part }}
            </td>
            <td class="tabborderin">
              {{ i.part_name }}
            </td>
            <td class="tabborderin">
              {{ i.masulemp ? i.masulemp.name : '' }}
            </td>
            <!-- <td class="tabborderin">
              <v-btn
                class="mx-1"
                color="error"
                text
                x-small
                @click="removeDetail(item.id, i.id)"
              >
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </td> -->
          </tr>
        </tbody>
      </table>
      <v-row class="my-0">
        <v-col></v-col>
        <v-col xl="1" lg="2" md="4">
          <v-select
            v-model="pagination.per_page"
            :items="[10, 20, 50, 100, 200]"
            color="#78909C"
            outlined
            dense
            hide-details
            @change="perPageUpdate"
          >
          </v-select>
        </v-col>
        <v-col xl="4" lg="6" md="7">
          <v-btn
            :disabled="arrow1"
            color="#78909C"
            outlined
            class="mx-1"
            @click="firstPage"
            ><v-icon>mdi-arrow-collapse-left</v-icon></v-btn
          >
          <v-btn
            :disabled="arrow2"
            color="#78909C"
            outlined
            class="mx-1"
            @click="prevPage"
            ><v-icon>mdi-arrow-left</v-icon></v-btn
          >
          {{ from }}-{{ to }} of {{ total }}
          <v-btn
            :disabled="arrow3"
            color="#78909C"
            outlined
            class="mx-1"
            @click="nextPage"
            ><v-icon>mdi-arrow-right</v-icon></v-btn
          >
          <v-btn
            :disabled="arrow4"
            color="#78909C"
            outlined
            class="mx-1"
            @click="lastPage"
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

export default {
  data() {
    return {
      loading: false,
      items: [],
      search: '',
      addDetailModal: false,
      VehicleModal: false,
      pagination: {
        page: 1,
        per_page: 10,
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
      form: {},
      modelType: null,
      newDetail: {
        part: [],
        setup_date: '',
      },
      addedDetail: [],
      details: [],
      selectedDetail: [],
      currentItem: '',
      detailSearchInput: '',
      filter: {
        model: null,
        vin: null,
        count: null,
      },
    };
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    screenHeight() {
      return window.innerHeight - 195;
    },
    modelItems() {
      return [
        { text: 'Lacetti', value: 'Lacetti' },
        { text: 'Nexia R3', value: 'Nexia R3' },
        { text: 'Spark', value: 'spark' },
        { text: 'Cobalt', value: 'Cobalt' },
      ];
    },
  },
  methods: {
    printVin(item) {
      let mywindow = window.open('', 'PRINT');
      mywindow.document.write('<html><head><title>' + item.vin + '</title>');
      mywindow.document.write(
        '<style>.itemSize{font-size:16pt}.text-center{text-align:center;} table > tbody > tr > td{margin:10px} @media print{@page {size: landscape} {-webkit-print-color-adjust: exact !important;}}</style>'
      );
      mywindow.document.write('</head><body >');
      mywindow.document.write(
        '<table border="1" style="margin: 10px;border-collapse: collapse;"><thead><tr ><th class="text-center" style="font-size:48pt">04<br /></th><th class="text-center" colspan="5"></th><th class="text-right"><img src="/logo.jpg" alt="UzAuto logo"width="50px"></th></tr></thead> <tbody>  <tr>    <td class="text-center" style="font-size: 38pt; width:60px">'
      );
      mywindow.document.write(
        '<div style="border: 1px solid; border-radius:50%">'
      );
      if (item.color == 1) {
        mywindow.document.write('W');
      } else if (item.color == 2) {
        mywindow.document.write('Y');
      } else {
        mywindow.document.write('A');
      }
      mywindow.document.write(
        '</div>    </td>    <td class="text-center" style="font-size: 48pt">№</td>'
      );
      mywindow.document.write(
        '<td class="text-center" colspan="5" style="font-size: 60pt">'
      );

      mywindow.document.write(item.vin);
      mywindow.document.write(
        '</td></tr><tr>  <td class="text-center" colspan="2" style="font-size: 30pt">Модель:</td>  <td class="text-center" style="width: 130px">Ишлаб чиқарилган сана:<br /></td>  <td class="text-center" style="width: 130px">Смена:<br /></td>  <td class="text-center" colspan="3" style="font-size: 28pt; white-space:nowrap">Сифат назоратидан масъул:</td></tr><tr >  <td class="text-center" colspan="2" style="font-size: 30pt">'
      );
      mywindow.document.write(item.modelname);
      mywindow.document.write('<br /></td>  <td class="text-center">');
      if (item.produced_date) {
        mywindow.document.write(item.produced_date);
      } else {
        mywindow.document.write('');
      }
      mywindow.document.write('</td>  <td class="text-center">');
      if (item.shift) {
        mywindow.document.write(item.shift);
      } else {
        mywindow.document.write('');
      }
      mywindow.document.write(
        '</td>  <td class="text-center" style="font-size: 22px" colspan="2">'
      );
      if (item.okby) {
        mywindow.document.write(item.okby.name);
      } else {
        mywindow.document.write('');
      }
      mywindow.document.write(
        '</td>  <td class="text-center" style="font-size: 22px; white-space:nowrap; display:flex; align-items:center; border:none"> <span style="margin-right:5px">мухр </span><div style="border: 1px solid; height:50px; width:50px; display: inline-block;"></div> <v-btn class="mx-2" outlined medium></v-btn>  </td></tr>'
      );
      mywindow.document.write(
        '<tr>  <td class="text-center"> №</td>    <td class="text-center">Деталь №</td>    <td class="text-center" colspan="2">Деталь номи	</td>    <td class="text-center">Таъминотчи корхона номи</td> <td class="text-center">Детальни етказиб келишга масъул шахс</td>    <td class="text-center">Тахминий ўрнатиш санаси:</td>  </tr>'
      );

      item.details.forEach((i, k) => {
        mywindow.document.write('<tr class="itemSize">');
        mywindow.document.write('<td class="text-center">' + (k + 1) + '</td>');
        mywindow.document.write('<td class="text-center">');
        mywindow.document.write(i.part);
        mywindow.document.write('</td>');
        mywindow.document.write('<td class="text-center" colspan="2">');
        mywindow.document.write(i.part_name);
        mywindow.document.write('</td>');
        mywindow.document.write('<td class="text-center">');
        mywindow.document.write(i.suplier);
        mywindow.document.write('</td>');
        mywindow.document.write('<td class="text-center">');
        i.masulemp ? mywindow.document.write(i.masulemp.name) : '';
        mywindow.document.write('</td>');
        mywindow.document.write(
          '<td class="text-center" style="white-space: nowrap">'
        );
        mywindow.document.write(item.setup_date.substr(0, 10));
        // mywindow.document.write(i.part);
        //     '<td class="text-center">ornatish sanasi</td></td><tr>  <td class="text-center">   1  </td>    <td class="text-center">nomi</td>    <td class="text-center" colspan="2">nomi</td>    <td class="text-center">nomi</td>    <td class="text-center">nopkmi</td>  </tr></tbody>  </table>'
        // );
        mywindow.document.write('</td>');
        mywindow.document.write('</tr>');
      });
      mywindow.document.write('</tbody>  </table>');
      mywindow.document.write('</body></html>');

      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10*/

      setTimeout(() => {
        mywindow.print();
        mywindow.close();
      }, 300);
      mywindow.onafterprint = this.afterPrint(item);
    },

    afterPrint(item) {
      console.log('loser');
      this.$axios
        .post(this.$store.state.backend_url + '/api/printVinAgain', {
          vinid: item.id,
        })
        .then((res) => {
          console.log(res);
          this.getVehicleList();
        })
        .catch((err) => {
          console.error(err);
        });
    },

    getVehicleList() {
      this.loading = true;
      this.$axios
        .post(this.$store.state.backend_url + '/api/report-count3', {
          pagination: this.pagination,
          search: this.search,
          model: this.modelType,
        })
        .then((res) => {
          this.items = res.data.data;
          if (this.user.role.name == 'sifat') {
            this.items = this.items.filter(
              (v) => v.ok_by == null && v.print_by == null
            );
          }
          if (this.user.role.name == 'supply') {
            this.items = this.items.filter(
              (v) => v.ok_by != null && v.print_by == null
            );
          }
          let qoldiq = res.data.total % res.data.per_page ? 1 : 0;
          this.items_count =
            parseInt(res.data.total / res.data.per_page) + qoldiq;
          if (res.data.current_page) {
            this.pagination.page = res.data.current_page;
          }
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
  width: 100%;
  border: 1px solid #78909c;
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
table > tbody > tr > td,
table > thead > tr > th {
  padding: 5px;
  border: 1px solid #ddd;
}
.tabborder {
  white-space: nowrap;
}
.tabborderin {
  white-space: nowrap;
  padding: 5px;
}
.rightborder:not(:last-child) {
  border-right: 1px solid;
}
</style>
