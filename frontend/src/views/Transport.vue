<template>
  <div class="mx-4 mt-4">
    <!-- ---------------------- -->
    <v-card class="mx-auto" max-width="600">
      <v-img
        class="white--text align-end"
        height="250px"
        src="./img/gos_nomer.gif"
      ></v-img>
      <v-col>
        <v-text-field
          v-model="filter.gos_number"
          ref="gos_number"
          label="Давлат рақамини киритинг"
          outlined
          append-icon="mdi-shield-search"
          counter="10"
          @keyup.native.enter="getInfo()"
        ></v-text-field>
      </v-col>
        <v-container fluid>
          <v-row dense>
            <v-col v-for="item in drivers" :key="item.indexof">
              <v-card class="mx-auto">
                <v-card-title>Транспорт</v-card-title>
                <div>Давлат рақами : {{ item.gos_number }}</div>
                <div>Йўл вароқаси ID : {{ item.waybill_id }}</div>
                <div>Йўл рақами :  {{ item.waybill_number }}</div>
                <v-card-title>Хайдовчи</v-card-title>
                <div>Исми : {{ item.first_name }} </div>
                <div>Фамилияси : {{ item.last_name }}</div>
                <div>Отасини исми : {{ item.middle_name }}</div>
                <div>телфон : {{ item.phone }}</div>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
    </v-card>
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
  </div>
</template>
<script>
export default {
  data() {
    return {
      loading: false,
      items: [],
      drivers: [],
      filter: {
        gos_number: null,
      },
    };
  },
  computed: {
    screenHeight() {
      return window.innerHeight - 210;
    },
  },
  methods: {
    getInfo() {
      this.loading = true;
      this.$axios
        .get(
          "https://b-garaj.uzautomotors.com/gosNumber/" +
            this.filter.gos_number
        )
        .then((response) => {
          this.drivers = response.data.drivers.map((v)=>({
            gos_number:response.data.gos_number,
            waybill_number:response.data.waybill_number,
            waybill_id:response.data.waybill_id,
            first_name:v.first_name,
            last_name:v.last_name,
            middle_name:v.middle_name,
            tabno:v.tabno,
            phone:v.phone
          }));
        });
        this.loading = false;
    },

    screenWidth() {
      return window.innerWidth;
    },
  },
  mounted() {},
};
</script>
<style>
.itemWidth {
  width: 15%;
}
.dialogHeight {
  max-height: 80%;
}
</style>
