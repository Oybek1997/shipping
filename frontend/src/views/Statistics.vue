<template>

    <div>
        <h1>Umumiy miqdor: {{ server_items_length }}</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                <th scope="col"><strong>#</strong></th>
                <th scope="col"><strong>Nomi:</strong></th>
                <th scope="col"><strong>Miqdor:</strong></th>
                </tr>
            </thead>
            <tbody v-for="dillerdata in dillersdata" :key="dillerdata.id">
                <tr>
                <th scope="row">{{ dillerdata.id }}</th>
                <td>{{ dillerdata.name }}</td>
                <td>{{ dillerdata.Count }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    
    </template>
    <script>
    import Swal from 'sweetalert2';
    let axios = require("axios").default;
    export default {
      data() {
        return {
          loading: false,
          vehicles: [],
          dillersdata: [],
          search: '',
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
            { text: this.$t('tr'), value: 'id', sortable: false },
            { text: this.$t('Name'), value: 'diler.name', sortable: false },
            { text: this.$t('VIN'), value: 'vin', sortable: false },
            { text: this.$t('Tabno'), value: 'tabno', sortable: false },
            { text: this.$t('Tcd_date'), value: 'tcd_time', sortable: false },
            {
              text: 'Amallar',
              align: 'center',
              value: 'options',
              sortable: false,
              width: 80,
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
            .post(this.$store.state.backend_url + '/api/getDilerWin', {
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
            .catch(function(error) {
              console.log(error);
              this.loading = false;
            });
        },
        editVehicle(item) {
          this.VehicleModal = true;
          this.form = Object.assign({}, item);
        },
        save() {
          this.$axios
            .post(this.$store.state.backend_url + '/api/vehicles/update', this.form)
            .then(() => {
              this.getVehicleList();
              this.VehicleModal = false;
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer);
                  toast.addEventListener('mouseleave', Swal.resumeTimer);
                },
              });
              Toast.fire({
                icon: 'success',
                title: this.$t('create_update_operation'),
              });
            });
        },
        deleteVehicle(item) {
          Swal.fire({
            title: this.$t('swal_title'),
            text: this.$t('swal_text'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: this.$t('swal_delete'),
          }).then((result) => {
            if (result.value) {
              this.$axios
                .delete(
                  this.$store.state.backend_url + '/api/vehicles/delete/' + item.id
                )
                .then((res) => {
                  console.log(res);
                  this.getVehicleList();
                  Swal.fire("O'chirildi!", this.$t('swal_deleted'), 'success');
                })
                .catch((err) => {
                  Swal.fire({
                    icon: 'error',
                    title: this.$t('swal_error_title'),
                    text: this.$t('swal_error_text'),
                    //footer: "<a href>Why do I have this issue?</a>"
                  });
                  console.log(err);
                });
            }
          });
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
              .post(this.$store.state.backend_url + "/api/dilers/get-excel", {
                filter: this.filter,
                type: 1,
                pagination: {
                  page: page,
                  itemsPerPage: 1000,
                },
              })
              .then((response) => {
                response.data.map((v, index) => {
                  new_array.push({
                    "№": index + page,
                    Name: v.Name,
                    Vin: v.Vin,
                    Tabno: v.Tabno,
                    Tcd_date: v.Tcd_date,
                  });
                });
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
        deleteFunction() {
          Swal.fire({
            title: this.$t('Delete'),
            text: this.$t('Delete Warning'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: this.$t('Delete All'),
          }).then((result) => {
            if (result.value) {
              this.$axios
                  .post(
                      this.$store.state.backend_url + '/api/delete-all'
                  )
                  .then((res) => {
                    console.log(res);
                    this.getVehicleList();
                    Swal.fire("O'chirildi!", this.$t('swal_deleted'), 'success');
                  })
                  .catch((err) => {
                    Swal.fire({
                      icon: 'error',
                      title: this.$t('swal_error_title'),
                      text: this.$t('swal_error_text'),
                      //footer: "<a href>Why do I have this issue?</a>"
                    });
                    console.log(err);
                  });
            }
          });
    
    
        },
        dilersData(){
            axios
                .get(this.$store.state.backend_url + "/api/dillersdata")
                .then((res) => {
                    this.dillersdata = res.data
                })
        }
      },
      mounted() {
        this.getVehicleList();
        this.dilersData();
        document.title = this.$t('drawings');
      },
    };
    </script>
    