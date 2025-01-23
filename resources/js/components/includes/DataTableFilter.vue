<template>
  <div class="row align-items-center mb-3">
    <div v-if="showDateFilter" class="row filter-object">
      <div class="col-md-4"></div>
      <div class="col-md-2">
        <label for="startDate">Start Date</label>
        <input type="date" id="startDate" v-model="startDate" class="form-control" />
      </div>
      <div class="col-md-2">
        <label for="endDate">End Date</label>
        <input type="date" id="endDate" v-model="endDate" class="form-control" />
      </div>
      <div class="col-md-2">
        <button @click="applyFilter" class="btn btn-primary mt-4">Apply</button>
      </div>
      <div class="col-md-2"></div>
    </div>
    <div class="table-responsive">
      <!-- Status Section -->
      <div v-if="mappedButton">
        <label for="status" class="label-style text-md-start mb-2">Mapped Status</label>
        <div class="form-group mb-3 d-flex gap-3">
          <div class="form-check" @change="mappedStatusTrack('all')">
            <input class="form-check-input" type="radio" id="all" value="false"
                   :checked="mappedStatus === 'all'" />
            <label class="form-check-label text-default label-style" for="all">All</label>
          </div>
          <div class="form-check" @change="mappedStatusTrack('unmapped')">
            <input class="form-check-input" type="radio" id="unmapped" value="false"
              :checked="mappedStatus === 'unmapped'" />
            <label class="form-check-label text-danger label-style" for="unmapped">Unmapped</label>
          </div>
          <div class="form-check" @change="mappedStatusTrack('mapped')">
            <input class="form-check-input" type="radio" id="mapped" value="true"
              :checked="mappedStatus === 'mapped'" />
            <label class="form-check-label text-success label-style" for="mapped">Mapped</label>
          </div>
        </div>
      </div>
      <table ref="dataTable" class="table datatable table-striped table-hover tabel-resign table-bordered mt-3">
        <thead>
          <tr>
            <th v-for="column in visibleColumns" :key="column.key">{{ column.label }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in filteredData" :key="index">
            <td v-for="column in visibleColumns" :key="column.key">
              <!-- Use slot if provided, fallback to default rendering -->
              <slot :name="column.key" :row="item" :column="column">
                {{ item[column.key] }}
              </slot>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>


<script>
import $ from "jquery";
import "datatables.net-bs5";

export default {
  name: "DataTableFilter",
  props: {
    data: {
      type: Array,
      required: true,
    },
    columns: {
      type: Array,
      required: true,
    },
    heading: {
      type: String,
      default: "",
    },
    headingIcon: {
      type: String,
      default: "",
    },
    initialStartDate: {
      type: String,
      default: "",
    },
    initialEndDate: {
      type: String,
      default: "",
    },
    showDateFilter: {
      type: Boolean,
      default: true,
    },
    searching: {
      type: Boolean,
      default: true,
    },
    mappedButton: {
      type: Boolean,
      default: false,
    },
    mappedStatus: {
      type: String,
      default: 'all',
    },
  },
  data() {
    return {
      startDate: this.initialStartDate,
      endDate: this.initialEndDate,
      filteredData: [...this.data],
    };
  },
  computed: {
    visibleColumns() {
      return this.columns.filter((column) => !column.hidden);
    },
  },
  watch: {
    data: {
      immediate: true,
      handler() {
        this.filterData();
      },
    },
  },
  mounted() {
    this.initializeDataTable();
  },
  updated() {
    this.refreshDataTable();
  },
  methods: {
    applyFilter() {
      this.filterData();
    },
    mappedStatusTrack(status) {
      this.$emit("mapped-status-track", { mapStatus: status });
    },
    filterData() {
      const startDateObj = this.startDate ? new Date(this.startDate) : null;
      const endDateObj = this.endDate ? new Date(this.endDate) : null;

      this.filteredData = this.data.filter((item) => {
        const itemDate = new Date(item.uploaded_date);
        return (
          (!startDateObj || itemDate >= startDateObj) &&
          (!endDateObj || itemDate <= endDateObj)
        );
      });

      this.$emit("filter-applied", { startDate: this.startDate, endDate: this.endDate });
      this.refreshDataTable();
    },
    initializeDataTable() {
      $(this.$refs.dataTable).DataTable({
        paging: true,
        searching: this.searching,
        ordering: true,
        destroy: true,
      });
    },
    refreshDataTable() {
      const table = $(this.$refs.dataTable).DataTable();
      table.clear();
      table.rows.add(
        this.filteredData.map((item) =>
          this.visibleColumns.map((column) => item[column.key])
        )
      );
      table.draw();
    },
  },
};
</script>

<style scoped>
/* Style for the button */
.btn-primary {
  background: linear-gradient(45deg, #7c2c82, #ea2129);
  color: #fff;
}

/*.dataTable thead th {
  border: none;
}*/

/*.dataTable tbody tr td {
  background: transparent;
  border: none;
  background: #fff;
}*/
</style>
