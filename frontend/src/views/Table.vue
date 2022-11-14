<template>
  <div class="mx-4 mt-4">
    <v-card class="elevation-5">
      <v-card-title>
        <v-simple-table fixed-header>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-center">04<br /></th>
                <th class="text-center" colspan="4"></th>
                <th class="text-right">
                  <img
                    src="https://edo.uzautomotors.com/img/gm/logo.jpg"
                    alt="UzAuto logo"
                    width="50px"
                  />
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center">
                  <v-btn class="mx-2" fab outlined small>Y</v-btn>
                </td>
                <td class="text-center">№</td>
                <td class="text-center" colspan="4">XWBTF69V9NA127146</td>
              </tr>
              <tr>
                <td class="text-center" colspan="2">model</td>
                <td class="text-center">ishlab chiqarilgan sana<br /></td>
                <td class="text-center">Smena<br /></td>
                <td class="text-center" colspan="2">sifat nazorati</td>
              </tr>
              <tr>
                <td class="text-center" colspan="2">nexia<br /></td>
                <td class="text-center">10.09.2022</td>
                <td class="text-center">1</td>
                <td class="text-center">Jumaboyev</td>
                <td class="text-left">
                  Muhr <v-btn class="mx-2" outlined medium></v-btn>
                </td>
              </tr>
              <tr>
                <td class="text-center">№</td>
                <td class="text-center">Partnumber</td>
                <td class="text-center" colspan="2">Partname</td>
                <td class="text-center">Supplier</td>
                <td class="text-center">ornatish sanasi</td>
              </tr>
              <tr v-for="item in desserts" :key="item.name">
                <td class="text-center">
                  {{ desserts.map((v) => v.id).indexOf(item.id) }}
                </td>
                <td class="text-center">{{ item.calories }}</td>
                <td class="text-center" colspan="2">{{ item.name }}</td>
                <td class="text-center">{{ item.calories }}</td>
                <td class="text-center">{{ item.calories }}</td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-title>
    </v-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      desserts: [
        {
          name: 'Frozen Yogurt',
          calories: 159,
        },
        {
          name: 'Ice cream sandwich',
          calories: 237,
        },
        {
          name: 'Eclair',
          calories: 262,
        },
        {
          name: 'Cupcake',
          calories: 305,
        },
        {
          name: 'Gingerbread',
          calories: 356,
        },
        {
          name: 'Jelly bean',
          calories: 375,
        },
        {
          name: 'Lollipop',
          calories: 392,
        },
        {
          name: 'Honeycomb',
          calories: 408,
        },
        {
          name: 'Donut',
          calories: 452,
        },
        {
          name: 'KitKat',
          calories: 518,
        },
      ],
    };
  },
};
</script>
<style scoped>
td {
  border: 1px solid black;
}
</style>
