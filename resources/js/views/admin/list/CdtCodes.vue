<template>
  <div class="table-datadesign">
    <div class="row top-sction">
      <div class="row header-row dashboard-row mb-4">
        <div class="col-md-6">
          <h4 class="headline-font">
            <img src="/images/number-blocks.png" class="site-icons"> CDT Code List
          </h4>
        </div>
        <div class="col-md-6 text-end">
          <div class="action_btn">
            <button @click="createCdtCodes" type="button" class="btn btn-primary">
              <i class="fa fa-plus" aria-hidden="true"></i> Create
            </button>
          </div>
        </div>
      </div>

      <!-- Data Table with Filter -->
      <DataTableFilter v-if="dataLoad" :data="cdtCodesList" :mappedButton="true" :columns="columns"
        :showDateFilter="false" @filter-applied="handleFilter" @mapped-status-track="handleMappedStatus"
        :searching="true" :mappedStatus="mappedStatus">
        <template #action="{ row }">
          <i :id="row.id" class="fa fa-edit cursor-pointer me-2 f-icon" @click="updateCdtCodes(row)"></i>&nbsp;
          <i :id="row.id" class="fas fa-trash-alt cursor-pointer me-2 f-icon" @click="deleteCdtCodes(row.id)"></i>
        </template>
      </DataTableFilter>

      <CDTCodeCrudPopup :visible="showModal" :config="config" :CDTCodesData="selectedCdtCodes" @close="closeModal"
        @submit="handleSubmit" />
    </div>
  </div>
</template>

<script>
import CDTCodeCrudPopup from "@/components/Admin/CDTCodeCrudPopup.vue";
import DataTableFilter from "@/components/includes/DataTableFilter.vue";
import { Api } from "@/api/api.js";
import axios from "axios";
import cdtCodes from '@/composables/cdtCodes'

export default {
  name: 'CDT Codes List',
  components: { DataTableFilter, CDTCodeCrudPopup },
  data() {
    return {
      config: {
        title: 'Create CDTCodes',
        action: 'create',
      },
      cdtCodesList: [],
      columns: [
        { key: 'name', label: 'Name' },
        { key: 'description', label: 'Description' },
        { key: 'procedure_template_count', label: 'No. of Templates' },
        { key: 'status', label: 'Status' },
        { key: 'action', label: 'Action' },
      ],
      mappedStatus: 'all',
      showModal: false,
      dataLoad: false,
      selectedCdtCodes: { name: '', description: '', status: '' },
    };
  },

  created() {
    this.getCdtCodesList(this.mappedStatus)
  },

  methods: {

    async getCdtCodesList(mappedStatus) {
      try {
        const cdtCodeService = cdtCodes();
        let cdtCodesList = await cdtCodeService.getCdtCodeList(mappedStatus);
        this.cdtCodesList = cdtCodesList.map((element) => ({
          id: element.id,
          name: element.name,
          description: element.description,
          procedure_template_count: element.procedure_templates_count,
          status: element.is_active ? 'Active' : 'Inactive',
          action: ''
        }));
        this.mappedStatus = mappedStatus;
        this.dataLoad = true;

      } catch (err) {
        this.$swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
        });
      }
    },

    handleMappedStatus(mappedStatus) {
      this.dataLoad = false;
      this.getCdtCodesList(mappedStatus.mapStatus);
    },

    createCdtCodes() {
      this.showModal = true;
      this.selectedCdtCodes = { name: '', description: '', status: 'Active' };
      this.config = { title: 'Create CDT Codes', action: 'create' };
    },

    closeModal() {
      this.showModal = false;
    },

    handleFilter(filterData) {
      console.log('Filter applied 1:', filterData);
    },

    updateCdtCodesData(updateData, id) {
      axios
        .post(`${Api.updateCdtCode}/${id}`, updateData)
        .then((response) => {
          const result = response.data;
          if (result.status === "success") {
            this.$swal
              .fire({
                icon: "success",
                title: "Success",
                text: "CDT Code updated successfully!",
              })
              .then(() => {
                this.dataLoad = false;
                this.getCdtCodesList(false);
              });
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Error",
              text: result.message || "An error occurred while updating the brand.",
            });
          }
        }).catch((error) => {
          console.error("Error updating data:", error);
        });
    },

    handleSubmit(selectedCdtCodes) {
      if (!selectedCdtCodes.name) return;
      if (!selectedCdtCodes.id) {
        this.createCdtCodesData(selectedCdtCodes);
      } else {
        this.updateCdtCodesData(selectedCdtCodes, selectedCdtCodes.id);
      }
    },
    createCdtCodesData(createdData) {
      axios
        .post(Api.createCdtCode, createdData)
        .then((response) => {
          const result = response.data;
          if (result.status === "success") {
            this.$swal
              .fire({
                icon: "success",
                title: "Success",
                text: "New CDT Code Created!",
              })
              .then(() => {
                this.dataLoad = false;
                this.getCdtCodesList(false);
              });
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: "CDT Code Already Exist",
            });
          }
        })
        .catch((error) => {
          console.error("Error creating data:", error);
        });
    },
    updateCdtCodes(row) {
      const mappedRow = {
        id: row.id,
        name: row.name,
        description: row.description,
        status: row.status,
        action: row.action
      };
      this.selectedCdtCodes = { ...mappedRow };
      console.log('this.selectedCdtCodes', this.selectedCdtCodes);
      this.config = { title: "Update CDT Codes", action: "update" };
      this.showModal = true;
    },

    deleteCdtCodes(id) {
      this.$swal
        .fire({
          title: "Are you sure?",
          text: "Do you really want to delete this brand? This action cannot be undone.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(`${Api.deleteCdtCode}/${id}`)
              .then((response) => {
                const result = response.data;
                if (result.status === "success") {
                  this.$swal
                    .fire({
                      icon: "success",
                      title: "CDT Code Deleted",
                      text: "The CDT Code has been successfully deleted.",
                    })
                    .then(() => {
                      this.dataLoad = false;
                      this.getCdtCodesList(false);
                    });
                } else {
                  this.$swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: result.data.message,
                  });
                }
              })
              .catch((error) => {
                console.error("Error deleting brand:", error);
              });
          }
        });
    },
  }
}
</script>
<style scoped></style>
