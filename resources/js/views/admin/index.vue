<template>
  <div class="app-body">
    <div class="row">
      <div class="col-12 mt-0">
        <!-- Row starts -->
        <div class="row gx-3">
          <div class="col-sm-12">
            <div class="card mb-3 bg-4">
              <div class="card-body mh-230">
                <!-- Row starts -->
                <div class="row gx-3">
                  <div class="col-sm-9 gaprole-mange">
                    <div class="text-white mt-3">
                      <h6>Good Morning,</h6>
                      <h3>{{user.name}}</h3>
                      <h5>Total <span class="badge bg-success">{{ todayAppointmentCount }} procedures</span> today.</h5>
                      <router-link :to="{ name: 'procedures.list' }" class="btn btn-danger mt-3 text-white">
                        <span class="d-none d-sm-inline">Book Procedure</span>
                      </router-link>
                    </div>
                  </div>
                </div>
                <!-- Row ends -->
              </div>
            </div>
          </div>
        </div>
        <!-- Row ends -->
      </div>
    </div>
    <div class="row gx-3 seccond-row-designicon">
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card mb-3 green">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="p-2 border border-success rounded-circle me-3">
                <div class="icon-box md bg-success-subtle rounded-5">
                  <i class="fas fa-tooth"></i>
                </div>
              </div>
              <div class="d-flex flex-column">
                <h2 class="lh-1">{{ newAppointment }}</h2>
                <p class="m-0">Upcoming Procedures</p>
              </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-1">
              <router-link :to="{ name: 'procedures.list' }" class="nav-link text-success">
                <span class="d-none d-sm-inline ps-2">View All</span> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
              </router-link>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card mb-3 blue">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="p-2 border border-primary rounded-circle me-3">
                <div class="icon-box md bg-primary-subtle rounded-5">
                  <i class="fas fa-layer-group"></i>
                </div>
              </div>
              <div class="d-flex flex-column">
                <h2 class="lh-1">{{ totalItems }}</h2>
                <p class="m-0">Total Items</p>
              </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-1">
              <router-link :to="{ name: 'items.list' }" class="nav-link text-primary">
                <span class="d-none d-sm-inline ps-2">Total Item</span> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
              </router-link>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card mb-3 red">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="p-2 border border-danger rounded-circle me-3">
                <div class="icon-box md bg-danger-subtle rounded-5">
                  <i class="fas fa-flask"></i>
                </div>
              </div>
              <div class="d-flex flex-column">
                <h2 class="lh-1">{{ unmappedCdtCodesCount }}</h2>
                <p class="m-0">Unmapped CDT Codes</p>
              </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-1">
              <router-link :to="{ name: 'cdt-codes.list' }" class="nav-link">
                <span>View All</span><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
              </router-link>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card mb-3">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="p-2 border border rounded-circle me-3">
                <div class="icon-box md rounded-5" style="background-color: #c8c8c8;">
                  <i class="fas fa-syringe"></i>
                </div>
              </div>
              <div class="d-flex flex-column">
                <h2 class="lh-1">{{ totalAppointment }}</h2>
                <p class="m-0">Completed Procedures</p>
              </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-1">
              <router-link :to="{ name: 'procedures.list' }" class="nav-link" style="color: #000;">
                <span>View All</span>
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="chart" class="chart-bg card"></div>


    <!-- Row starts -->

    <div class="row gx-3">
      <div class="col-xxl-8 col-sm-12">
        <div class="card mb-3 appmtrole2">
          <div id="lowstockchart" class="chart-bg"></div>
        </div>
      </div>


      <div class="col-xxl-4 col-sm-6">
        <div class="card mb-3 appmtrole2 dashboard-upcoming-procedure">
          <div class="card-header">
            <h5 class="card-title" style="font-size: 20px !important;">Upcoming Procedures</h5>
          </div>
          <div class="card-body appmtrole">

            <div class="scroll300 os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition"><div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div><div class="os-content-glue" style="margin: 0px; width: 359px; height: 420px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;"><div class="os-content" style="padding: 0px; height: 100%; width: 100%;">
              <div class="d-flex flex-column gap-2">
                <div class="p-3 border rounded-2 manage-process" v-for="data in upcomingAppointmentDetails" :key="data.id" :value="data.id">
                  <div class="text-center mb-0">
                    <p class="m-0 text-bold text-start"> <strong><i class="fas fa-user"></i>  Name: </strong>{{data.patient_name }}</p>
                    <P class="m-0 text-bold text-start"><strong><i class="fas fa-envelope-open"></i> Email: </strong>{{ data.patient_email }}</p>
                    <p class="m-0 text-bold text-start"><strong><i class="fas fa-calendar-alt"></i> Procedure Date: </strong>{{ data.procedure_date }}</p>
                  </div>
                </div>
              </div>
            </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track os-scrollbar-track-off"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden"><div class="os-scrollbar-track os-scrollbar-track-off"><div class="os-scrollbar-handle" style="height: 53.7634%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div></div>

          </div>
        </div>
      </div>
    </div>
    <!-- Row ends -->
  </div>
</template>

<script>
import { useAuthStore } from "@/store/auth";
import ApexCharts from "apexcharts";
import dashboard from '@/composables/dashboard'

export default {
  name: "Dashboard",
  data() {
    return {
      lowStockItemsData:[],
      mostUsedItemData: [],
      dataLoaded: false,
      todayAppointmentCount: 0,
      newAppointment: 0,
      totalItems: 0,
      totalAppointment: 0,
      unmappedCdtCodesCount: 0,
      upcomingAppointmentDetails: [],
    };
  },
  computed: {
    user() {
      return useAuthStore().user;
    },
  },

  mounted() {
    this.getDashboardData()
  },

  watch: {
    dataLoaded: {
      handler(newData) {
        if (newData === true) {
          console.log('dataLoaded lowStockItemsData ', this.lowStockItemsData)
          this.renderBarChart()
          this.renderLowStockBarChart()
        }
      },
      deep: true,
      immediate: true,
    },
  },

  methods: {
    getCurrentFormattedDate() {
      const now = new Date();

      const year = now.getFullYear();
      const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
      const day = String(now.getDate()).padStart(2, '0');

      const hours = String(now.getHours()).padStart(2, '0');
      const minutes = String(now.getMinutes()).padStart(2, '0');
      const seconds = String(now.getSeconds()).padStart(2, '0');

      return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    },
    renderBarChart() {
      const categories = [];
      const stockData = [];
      const lastWeekData = this.mostUsedItemData.last_week;
      for (let i = 0; i < lastWeekData.length; i++) {
        categories.push(lastWeekData[i].item_name);
        stockData.push(lastWeekData[i].total_quantity);
      }
      const options = {
        series: [
          {
            name: "Total Quantity",
            data: stockData,
          },
        ],
        chart: {
          type: 'bar',
          height: 350,
          toolbar: {
            show: false,
          },
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '75%',
            endingShape: 'rounded',
          },
        },
        title: {
          text: 'Top 5 Most used Item (Last Week)',
        },
        xaxis: {
          categories: categories,
        },
        yaxis: {
          title: {
            text: 'Total Quantity',
          },
        },
        fill: {
          opacity: 1,
        },
        legend: {
          position: 'top',
          horizontalAlign: 'center',
        },
        colors: ['#49c088'],
      };

      let chart1 = new ApexCharts(document.querySelector("#chart"), options);
      chart1.render();
    },


    renderLowStockBarChart() {
      const categories = [];
      const stockData = [];

      for (let index = 0; index < this.lowStockItemsData.length; index++) {
        categories.push(this.lowStockItemsData[index].name);
        stockData.push(this.lowStockItemsData[index].total_stock_quantity);
      }

      let options = {
        series: [
          {
            name: "Group 1",
            data: stockData,
          },
        ],
        chart: {
          type: 'bar',
          height: 350,
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '75%',
            endingShape: 'rounded'
          }
        },
        title: {
          text: 'Low Stock Items'
        },
        xaxis: {
          categories: categories  // Use the categories array here
        },
        yaxis: {
          title: {
            text: 'Count'
          }
        },
        fill: {
          opacity: 1
        },
        legend: {
          position: 'top',
          horizontalAlign: 'center'
        },
        colors: ['#d7d73d'],
      };

      let chart1 = new ApexCharts(document.querySelector("#lowstockchart"), options);
      chart1.render();
    },

    async getDashboardData() {
      try {
        const dashboardService = dashboard();
        let dashboardData = await dashboardService.getDashboardData();

        this.lowStockItemsData = Object.values(dashboardData.getLowStockItems);
        this.mostUsedItemData = dashboardData.getMostUsedItems || {};
        this.todayAppointmentCount = dashboardData.todayAppointmentCount || 0;
        this.newAppointment = dashboardData.newAppointment.length || 0;
        this.totalItems = dashboardData.totalItems || 0;
        this.totalAppointment = dashboardData.totalAppointment || 0;
        this.unmappedCdtCodesCount = dashboardData.unmappedCdtCodesCount || 0;
        this.upcomingAppointmentDetails = dashboardData.newAppointment;


        await this.$nextTick(() => {
          this.dataLoaded = true;
        });
      } catch (err) {
        this.$swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
        });
      }
    },
  },
};
</script>

<style>
#chart {
  width: 100%;
  height: 400px;
}

table {
  width: 50%;
  border-collapse: collapse;
  margin: 20px 0;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f4f4f4;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}
.dashboard-upcoming-procedure p.m-0.text-bold.text-start {
  line-height: 2;
  font-size: 18px;
}
</style>
