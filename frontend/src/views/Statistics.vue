<template>
  <div>
    
    <v-footer padless>
    <v-col
      class="text-center"
      cols="12"
    >
    <h5>Умумий микдор — {{server_items_length}}</h5>
    </v-col>
  </v-footer>
  <v-data-table
    :headers="headers"
    :items="dillersdata"
    :options.sync="dataTableOptions"
    fixed-header
    class="elevation-1"
    :height="screenHeight"
    :footer-props="{
      itemsPerPageOptions: [10, 20, 50, -1],
      itemsPerPageAllText: $t('itemsPerPageAllText'),
      itemsPerPageText: $t('itemsPerPageText'),
      showFirstLastPage: true,
    }"
    @update:options="dilersData()"
  >
    <template v-slot:[`item.number`]="{ item }">
      {{ dillersdata.indexOf(item) + 1 }}
    </template>
    <template v-slot:[`item.name`]="{ item }">
      {{ item.name }}
    </template>
    <template v-slot:[`item.soni`]="{ item }">
      {{ item.soni!=0?item.soni:0 }}
    </template>
  </v-data-table>
  </div>
</template>
<script>
let axios = require("axios").default;
export default {
  data() {
    return {
      loading: false,
      vehicles: [],
      dillersdata: [],
      search: "",
      VehicleModal: false,
      form: {},
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
        {
          text: "№",
          value: "number",
          align: "center",
          width: "10",
          class: "white--text blue darken-2",
        },
        {
          text: "Диллер номи",
          value: "name",
          align: "center",
          width: "100",
          class: "white--text blue darken-2",
        },
        {
          text: "Микдори",
          value: "soni",
          align: "center",
          width: "10",
          class: "white--text blue darken-2",
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
        .post(this.$store.state.backend_url + "/api/getDilerWin", {
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
    dilersData() {
      axios
        .get(this.$store.state.backend_url + "/api/dillersdata")
        .then((res) => {
          this.dillersdata = res.data;
          console.log("Info=", this.dillersdata);
        });
    },
  },
  mounted() {
    this.getVehicleList();
    this.dilersData();
    document.title = this.$t("drawings");
  },
};
</script>
