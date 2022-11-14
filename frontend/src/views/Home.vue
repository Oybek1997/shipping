<template>
  <div class="fullHeight">
    <!-- <v-row class="ma-4">
      <v-col >
        <v-hover v-slot="{ hover }">
          <v-card color="#385F73" dark :elevation="hover ? 24 : 0" to="/report1">
            <v-card-title class="text-h5">Detallar hisoboti</v-card-title>
          <v-card
            color="#385F73"
            dark
            :elevation="hover ? 24 : 0"
            to="/report1"
          >
            <v-card-title class="text-h5">
              Detallar hisoboti
            </v-card-title>
            <v-card-text>
              <v-icon large>mdi-car-cog</v-icon>
            </v-card-text>
          </v-card>
        </v-hover>
      </v-col>
      <v-col>
        <v-hover v-slot="{ hover }">
          <v-card color="#385F73" dark :elevation="hover ? 24 : 0" to="/monthreport">
            <v-card-title class="text-h5">Omborlar hisoboti</v-card-title>
          <v-card
            color="#385F73"
            dark
            :elevation="hover ? 24 : 0"
            to="/monthreport"
          >
            <v-card-title class="text-h5">
              Omborlar hisoboti
            </v-card-title>
            <v-card-text>
              <v-icon large>mdi-city</v-icon>
            </v-card-text>
          </v-card>
        </v-hover>
      </v-col>
      <v-col>
        <v-hover v-slot="{ hover }">
          <v-card color="#385F73" dark :elevation="hover ? 24 : 0" to="/modelreport">
            <v-card-title class="text-h5">Modellar hisoboti</v-card-title>
          <v-card
            color="#385F73"
            dark
            :elevation="hover ? 24 : 0"
            to="/modelreport"
          >
            <v-card-title class="text-h5">
              Modellar hisoboti
            </v-card-title>
            <v-card-text>
              <v-icon large>mdi-car</v-icon>
            </v-card-text>
          </v-card>
        </v-hover>
      </v-col>
      <v-col>
        <v-hover v-slot="{ hover }">
          <v-card color="#385F73" dark :elevation="hover ? 24 : 0" to="/warehousereport">
            <v-card-title class="text-h5">Modellar va omborlar hisoboti</v-card-title>
          <v-card
            color="#385F73"
            dark
            :elevation="hover ? 24 : 0"
            to="/warehousereport"
          >
            <v-card-title class="text-h5">
              Modellar va omborlar hisoboti
            </v-card-title>
            <v-card-text>
              <v-icon large>mdi-database</v-icon>
            </v-card-text>
          </v-card>
        </v-hover>
      </v-col>
    </v-row>-->
    <!-- <img
      src="@/assets/g04.png"
      alt
      width="70%"
      style="margin-left: auto; margin-right: auto; display: block;"
    />-->
    <v-row class="pa-6 mx-0 my-6" style="display: flex; align-items: flex-end">
      <v-col class="pa-0" md="12" sm="12" xs="12">
        <v-card
          class="d-flex align-content-start justify-space-between"
          flat
          tile
        >
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                class="ma-2  c17a2b8"
                width="25%"
                :class="`elevation-${hover ? 16 : 3}`"
                style="border-radius: 5px"
              >
                <v-card-title class="card_title px-2">{{
                  $t('04 Mashinalar soni')
                }}</v-card-title>
                <v-card-title class="card_title-number pt-0 pb-6">
                  {{ stats.vehicles04 }}
                  <v-icon large>mdi-car-cog</v-icon>
                </v-card-title>
                <v-divider class="ml-3 mr-3" color="black"></v-divider>
                <v-card-title class="card_title pt-3 pb-0">
                  Jami mashinalar
                </v-card-title>
                <v-card-title class="card_title-number pt-0 pb-6">
                  {{ stats.all_vehicles }}</v-card-title
                >
                <v-card-subtitle
                  color="black"
                  class="card_sub--title py-2 mx-0"
                  >{{ $t('Mashinalar') }}</v-card-subtitle
                >
              </v-card>
            </template>
          </v-hover>
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                class="ma-2  c17a2b8"
                width="25%"
                :class="`elevation-${hover ? 16 : 3}`"
                style="border-radius: 5px"
              >
                <v-card-title class="card_title px-2">{{
                  $t('Tanqis detallar')
                }}</v-card-title>
                <v-card-title class="card_title-number pt-0 pb-6">
                  {{ stats.all_details04 }}
                  <v-icon large>mdi-car-cog</v-icon>
                </v-card-title>
                <v-divider class="ml-3 mr-3" color="black"></v-divider>
                <v-card-title class="card_title pt-3 pb-0">
                  Jami detallar
                </v-card-title>
                <v-card-title class="card_title-number pt-0 pb-6">
                  {{ stats.all_details }}</v-card-title
                >
                <v-card-subtitle
                  color="black"
                  class="card_sub--title py-2 mx-0"
                  >{{ $t('Detallar') }}</v-card-subtitle
                >
              </v-card>
            </template>
          </v-hover>
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                class="ma-2 c17a2b8"
                width="25%"
                :class="`elevation-${hover ? 16 : 3}`"
                style="border-radius: 5px"
              >
                <v-card-title class="card_title px-2">{{
                  $t('Ombordagi mashinalar')
                }}</v-card-title>
                <v-card-title class="card_title-number pt-0 pb-6">
                  {{ stats.all_warehouse_vehicle }}
                  <v-icon large>mdi-car-cog</v-icon>
                </v-card-title>
                <v-divider class="ml-3 mr-3" color="black"></v-divider>
                <v-card-title class="card_title pt-3 pb-0">
                  Jami omborlar
                </v-card-title>
                <v-card-title class="card_title-number pt-0 pb-6">
                  {{ stats.all_warehouses }}</v-card-title
                >
                <v-card-subtitle
                  color="black"
                  class="card_sub--title py-2 mx-0"
                  >{{ $t('Omborlar') }}</v-card-subtitle
                >
              </v-card>
            </template>
          </v-hover>
          <v-hover>
            <template v-slot="{ hover }">
              <v-card
                class="ma-2 c17a2b8"
                width="25%"
                :class="`elevation-${hover ? 16 : 3}`"
                style="border-radius: 5px"
              >
                <v-card-title class="card_title px-2">{{
                  $t('Jami modellar')
                }}</v-card-title>
                <v-card-title class="card_title-number pt-0 pb-6">
                  {{ stats.all_models }}
                  <v-icon large>mdi-car-cog</v-icon>
                </v-card-title>
                <v-divider class="ml-3 mr-3" color="black"></v-divider>
                <v-card-title class="card_title pt-3 pb-0">
                  Jami mashinalar
                </v-card-title>
                <v-card-title class="card_title-number pt-0 pb-6">
                  {{ stats.all_vehicles }}</v-card-title
                >
                <v-card-subtitle
                  color="black"
                  class="card_sub--title py-2 mx-0"
                  >{{ $t('Modellar') }}</v-card-subtitle
                >
              </v-card>
            </template>
          </v-hover>
        </v-card>
      </v-col>
    </v-row>
    <v-divider class="my-10"></v-divider>
    <v-row class="ma-6">
      <v-col sm="6" class="mt-12">
        <PieChart />
      </v-col>
      <v-col sm="6" class="mt-12">
        <DoughnutChart />
      </v-col>
      <v-col sm="6" class="mt-12">
        <BarChart />
      </v-col>
      <v-col sm="6" class="mt-12">
        <BarelChart />
      </v-col>
    </v-row>
  </div>
</template>
<script>
import BarelChart from '../components/Barel.vue';
import BarChart from '../components/Bar.vue';
import PieChart from '../components/Pie.vue';
import DoughnutChart from '../components/Doughnut.vue';
const axios = require('axios').default;
export default {
  components: {
    BarChart,
    BarelChart,
    PieChart,
    DoughnutChart,
  },
  data() {
    return {
      stats: [],
    };
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
  methods: {
    res() {
      this.loading = true;
      axios
        .get(this.$store.state.backend_url + '/api/apifive')
        .then((response) => {
          this.stats = response.data;
          console.log(this.stats);
        })
        .catch((error) => {
          console.log(error);
          this.loading = false;
        });
    },
  },
  mounted() {
    this.res();
    document.title = this.$t('main_page');
    // this.downloadPart();
    // this.getAllFile();
  },
};
</script>
<style scoped>
.dashboard_bg {
  background: #fff;
}
.dashboard__title {
  color: #205c7c;
  font-size: 40px;
  font-weight: 700;
  text-shadow: 0 2px 3px rgba(60, 60, 60, 0.25);
}
.dashboard__togglers {
  display: flex;
  justify-content: center;
}
.dashborad_date_toggler {
  background: transparent;
  /* border: 1px solid #205c7c; */
  /* border-radius: 18px; */
  pointer-events: initial;
  overflow: hidden;
}
.dashboard_manager_toggler {
  background: transparent;
  /* border: 1px solid #205c7c; */
  /* border-radius: 18px; */
  pointer-events: initial;
  overflow: hidden;
  display: flex;
  flex-direction: row;
}
.dashboard__togglers-toggler-item {
  color: #205c7c;
  height: 34px;
  text-transform: capitalize;
  font-family: 'Montserrat', Sans-serif;
}
.v-input__slot fieldset {
  border: none !important;
}
.v-text-field__slot {
  color: #fff !important;
}
.card_title {
  /* color: #000; */
  font-size: 12px;
  line-height: 1;
  letter-spacing: 0.03em;
  font-weight: 700;
  text-transform: uppercase;
  display: block;
  display: -webkit-box;
  max-width: 100%;
  height: 41px;
  margin: 0 auto;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  margin-bottom: 8px;
}
.card_sub--title {
  /* opacity:0.8; */
  font-size: 13px;
  line-height: 10px;
  margin-top: 8px;
  white-space: nowrap;
  overflow: hidden;
  color: #fff !important;
  line-height: 1.2;
  text-align: center;
  background-color: rgba(0, 0, 0, 0.1);
}
.card_title-number {
  font-size: 43px;
  font-weight: 600;
  color: #fff;
  display: flex;
  justify-content: space-between;
}
.card_title-number i {
  color: rgba(0, 0, 0, 0.15);
}
.card_title-sub--number {
  font-size: 19px;
  font-weight: 600;
  color: #fff;
}
.text-ellipsis {
  max-width: 100%;
  display: inline-block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.top-chart__pipeline {
  margin-right: 15px;
}
.top-chart__pipelines-item {
  text-overflow: ellipsis;
  overflow: hidden;
  max-width: 100%;
  display: inline-block;
  font-size: 12px;
  font-weight: 600;
  white-space: nowrap;
  text-transform: uppercase;
  line-height: 18px;
  color: #205c7c;
  text-decoration: none;
}
.top-chart_title {
  color: #fff;
  text-align: center;
  font-size: 14px;
  line-height: 1;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  /* text-shadow: 0 2px 3px rgba(0, 0, 0, 0.25); */
}
.top-chart_sub--title {
  color: #205c7c !important;
  font-size: 12px;
  line-height: 1;
  font-weight: 600;
  text-align: center;
  cursor: pointer;
}
.top-chart-number {
  display: block;
  color: #8275ff;
  text-align: center;
  font-weight: 600;
  font-size: 45px;
  /* text-shadow: 0 2px 3px rgba(0, 0, 0, 0.25); */
  margin-top: -10px;
}
.top-chart-sub--number {
  /* color: #000 !important; */
  text-align: center;
  font-weight: 700;
  font-size: 13px;
  /* text-shadow: 0 2px 3px rgba(0, 0, 0, 0.25); */
}
.top-chart_btn {
  color: #205c7c;
  text-align: center;
  font-size: 14px;
  line-height: 1;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
}
#top-chart-number {
  color: #205c7c;
}
#top-chart-sub--number {
  color: #205c7c;
  text-align: center;
  font-weight: 700;
  font-size: 13px;
  /* text-shadow: 0 2px 3px rgba(0, 0, 0, 0.25); */
}
.fullHeight {
  height: calc(100% - 0px);
}
.heightFull {
  height: 100%;
}
.fontSize35 {
  font-size: 30px;
}
.c17a2b8 {
  background: #17a2b8;
  color: #fff;
}
.c28a745 {
  background: #28a745;
  color: #fff;
}
.cffc107 {
  background: #ffc107;
  color: #fff;
}
.cdc3545 {
  background: #dc3545;
  color: #fff;
}
</style>
