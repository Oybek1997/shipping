<template>
  <div class="container-fluid mt-5">
    <v-footer padless>
    <v-col
      class="text-center"
      cols="12"
    >
    <h5>Умумий микдор — {{server_items_length}}</h5>
    </v-col>
  </v-footer>


  <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Диллер номи:</th>
      <th scope="col">Микдори:</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(dillerdata, itemObjKey) in dillersdata" :key="dillerdata.id">
      <th scope="row">{{itemObjKey + 1}}</th>
      <td>{{ dillerdata.name }}</td>
      <td>{{ dillerdata.ct }}</td>
      <td></td>
    </tr>
  </tbody>
</table>

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
          console.log(this.dillersdata);
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
