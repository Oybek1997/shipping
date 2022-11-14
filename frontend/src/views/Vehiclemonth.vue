<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        Omborlarni oylar bo'yicha hisoboti
        <v-spacer></v-spacer>

        <v-btn
            style="margin-left: 1450px"
            color="indigo"
            x-medium
            dark
            fab
            @click="tableToExcel('table', 'Lorem Table')"
        >
          <v-icon>mdi-file-excel-outline</v-icon>
        </v-btn>

      </v-card-title>
      <v-card-text>
        <table
            style="min-width:100%;border-collapse:collapse;"
            border="1"
            ref="table"
            id="table"
        >
          <thead>
            <tr>
              <template v-for="(i, k) in items[0]">
                <td :key="k">{{ months[i] }}</td>
              </template>
              <template v-if="loading == false">
                <td>{{ 'Jami:' }}</td>
              </template>
            </tr>
          </thead>
          <tbody
            v-for="(item, key) in items.filter((a, b) => b > 0)"
            :key="key"
          >
            <tr>
              <template v-for="(i, k) in item">
                <td v-if="k == 0" :key="k" rowspan="2" class="left">{{ i }}</td>
                <td v-else :key="k" class="right">{{ i[0] }}</td>
              </template>
              <template>
                <td class="right" >
                  {{
                    item.filter((s,w)=>w>0).reduce((a,b) => a+b[0], 0)
                  }}
                  </td>
              </template>
            </tr>
            <tr>
              <template v-for="(i, k) in item.filter((a, b) => b > 0)">
                <td  style="background-color: #FAFAD2" :key="k" class="right">{{ i[1] }}</td>
              </template>
              <template>
                <td class="right" style="background-color: #FAFAD2">
                  {{
                    item.filter((s,w)=>w>0).reduce((a,b) => a+b[1], 0 )
                  }}
                  </td>
              </template>
            </tr>
          </tbody>
        </table>
      </v-card-text>
      <v-dialog v-model="loading" width="300" hide-overlay>
        <v-card color="primary" dark>
          <v-card-text>
            {{ $t("loadingText") }}
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
import UTIF from "utif";
import TableToExcel from "@linways/table-to-excel";
export default {
  data() {
    return {
      loading: false,
      search: "",
      vehicle_details: [],
      vehicles: [],
      warehouse: [],
      items: [],
      months: {
        "01": "Yanvar",
        "02": "Fevral",
        "03": "Mart",
        "04": "Aprel",
        "05": "May",
        "06": "Iyun",
        "07": "Iyul",
        "08": "Avgust",
        "09": "Sentyabr",
        "10": "Oktyabr",
        "11": "Noyabr",
        "12": "Dekabr",
      },
    };
  },
  computed: {
    headers() {
      return [
        { text: this.$t("tr"), value: "id", sortable: false },
        { text: this.$t("Model"), value: "models", sortable: false },
        {
          text: this.$t("PONO"),
          value: "pono",
          sortable: false,
        },
      ];
    },
    headers2() {
      return [
        { text: this.$t("tr"), value: "id" },
        { text: this.$t("mpl.product"), value: "file", sortable: false },
      ];
    },
    screenHeight() {
      return window.innerHeight - 210;
    },
  },
  methods: {
    newMpl() {
      this.drawingModal = true;
      this.UserTitle = "ADD User";
      this.form = {
        id: Date.now(),
        name: "",
        username: "",
        email: "",
        tbnumber: "",
      };
    },

    getList() {
      this.loading = true;
      this.$axios
        .post(this.$store.state.backend_url + "/api/monthreport", {
          product: "gem",
        })
        .then((res) => {
          this.items = res.data;
          this.warehouse = res.data[1];
          this.loading = false;
        })
        .catch(function(error) {
          console.log(error);
          this.loading = false;
        });
    },
    screenWidth() {
      return window.innerWidth;
    },
    replace() {
      UTIF.replaceIMG();
    },
    tableToExcel() {
      TableToExcel.convert(document.getElementById("table"));
    }
  },
  mounted() {
    this.getList();
    this.replace();
    document.title = this.$t("drawings");
  },
};
</script>

<style scoped>
table > thead > tr > td {
  padding: 5px;
  font-weight: bold;
  text-align: center;
}
.right {
  padding: 5px;
  text-align: right;
}
.left {
  padding: 5px;
  font-weight: bold;
}
</style>
