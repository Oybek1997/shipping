<template>
  <div>
    <Pie
      :chart-options="chartOptions"
      :chart-data="chartData"
      :chart-id="chartId"
      :dataset-id-key="datasetIdKey"
      :plugins="plugins"
      :css-classes="cssClasses"
      :styles="styles"
      :width="width"
      :height="height"
    />
    <v-dialog v-model="loading" width="300" hide-overlay>
      <v-card color="primary" dark>
        <v-card-text>
          {{ $t("loadingText") }}
          <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
const axios = require("axios").default;
import { Pie } from "vue-chartjs/legacy";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale
} from "chart.js";
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);
export default {
  name: "PieChart",
  components: {
    Pie
  },
  props: {
    chartId: {
      type: String,
      default: "pie-chart"
    },
    datasetIdKey: {
      type: String,
      default: "label"
    },
    width: {
      type: Number,
      default: 400
    },
    height: {
      type: Number,
      default: 400
    },
    cssClasses: {
      default: "",
      type: String
    },
    styles: {
      type: Object,
      default: () => {}
    },
    plugins: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      loading: false,
      chartData: {
        // labels: ["VueJs", "EmberJs", "ReactJs"],
        labels: [],
        datasets: [
          {
            backgroundColor: ["#41B883", "#E46651", "#00D8FF"],
            data: [],
            // sata: [4]
          }
        ]
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false
      }
    };
  },
  methods: {
    dashboard() {
      this.loading = true;
      axios
        .get(this.$store.state.backend_url + "/api/apithree")
        .then(response => {
          this.chartData.labels = response.data.map((v)=>{
            return v.status;
          });
          this.chartData.datasets[0].data = response.data.map((v)=>{
            return v.count;
          });
          // console.log( this.chartData.datasets[0].data);
          
         
          this.loading = false;
        })
        .catch(error => {
          console.log(error);
          this.loading = false;
        });
    }
  },
  mounted() {
    this.dashboard();
  }
};
</script>