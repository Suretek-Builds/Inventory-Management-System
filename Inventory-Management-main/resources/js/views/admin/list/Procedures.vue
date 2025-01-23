<template>
  <div class="table-datadesign">
    <div class="row top-sction">
      <div class="row header-row dashboard-row mb-4">
        <div class="col-md-6">
          <h4 class="headline-font">
            <img src="/images/process-diagram.png" class="site-icons"> Procedures List
          </h4>
        </div>
        <div class="col-md-6 text-end">
          <div class="action_btn">
            <button @click="createProcedure" type="button" class="btn btn-primary">
              <i class="fa fa-plus" aria-hidden="true"></i> Create
            </button>
          </div>
        </div>
      </div>

      <!-- Data Table with Filter -->
      <DataTableFilter
        v-if="dataLoad"
        :data="proceduresList"
        :columns="columns"
        :showDateFilter="false"
        @filter-applied="handleFilter"
        :searching="true">
        <template #action="{ row }">
          <i v-if="this.formattedCurrentDate() > row.procedure_date" class="fa fa-edit cursor-pointer me-2 disable-icon" data-bs-toggle="tooltip" :title="'Procedure Already Completed'"></i>
          <i v-else :id="row.id" class="fa fa-edit cursor-pointer me-2 f-icon" @click="updateProcedure(row)"></i>&nbsp;
          <i :id="row.id" class="fas fa-trash-alt cursor-pointer me-2 f-icon" @click="deleteProcedure(row.id)"></i>
        </template>
      </DataTableFilter>

      <ProcedureCrudPopup
        :visible="showModal"
        :config="config"
        :procedureData="selectedProcedure"
        :cdtCodesList="cdtCodesList"
        @close="closeModal"
        @submit="handleSubmit" />

      <ProcedureOverview
        :itemsList="itemsList"
        :visible="procedureOverviewModalShow"
        @close="procedureOverviewModalShow = false"
        @submit="handleFinalSubmit"
        :procedureDetail="procedureOverviewData" />
    </div>
  </div>
</template>

<script>

import {Api} from '@/api/api.js';
import axios from "axios";
import DataTableFilter from "@/components/includes/DataTableFilter.vue";
import ProcedureCrudPopup from "@/components/Admin/ProcedureCrudPopup.vue";
import cdtCodes from '@/composables/cdtCodes';
import items from '@/composables/items'
import ProcedureOverview from "@/components/Admin/ProcedureOverview.vue";

export default {
  name: 'Procedures',

  components: {
    DataTableFilter,
    ProcedureCrudPopup,
    ProcedureOverview,
  },

  data() {
    return {
      showModal: false,
      dataLoad: false,
      proceduresList: [],
      columns: [
        { key: 'id', label: 'ID', hidden: true },
        { key: 'patient_name', label: 'Name' },
        { key: 'patient_email', label: 'Email' },
        { key: 'procedure_date', label: 'Procedure Date' },
        { key: 'gender', label: 'Gender' },
        { key: 'phone_number', label: 'Phone' },
        { key: 'age', label: 'Age'},
        { key: 'cdt_code_name', label: 'CDT Code'},
        { key: 'cdt_code', label: 'CDT', hidden: true },
        { key: 'template', label: 'Template', hidden: true },
        { key: 'action', label: 'Action' }
      ],
      config: {},
      selectedProcedure: {},
      cdtCodesList: [],
      itemsList: [],
      procedureOverviewData: {},
      procedureOverviewModalShow: false
    }
  },

  created() {
    this.getProcedures();
    this.getCdtCodesList();
    this.getItemsList();
  },

  methods: {
    formattedCurrentDate() {
      const now = new Date();
      return now.getFullYear() + '-' +
        String(now.getMonth() + 1).padStart(2, '0') + '-' +
        String(now.getDate()).padStart(2, '0') + ' ' +
        String(now.getHours()).padStart(2, '0') + ':' +
        String(now.getMinutes()).padStart(2, '0') + ':' +
        String(now.getSeconds()).padStart(2, '0');
    },
    async getCdtCodesList() {
      try {
        const cdtCodeService = cdtCodes();
        let cdtCodesList = await cdtCodeService.getCdtCodeList('mapped');
        this.cdtCodesList = cdtCodesList.map((element) => ({
          id: element.id,
          name: element.name,
          procedure_templates: element.procedure_templates,
        }));
      } catch (err) {
        console.error('Error while fetching CDT codes list.');
      }
    },

    async getItemsList() {
      try {
        const itemService = items();
        let itemsList = await itemService.getItemsList();
        this.itemsList = itemsList.map((element) => ({
          id: element.id,
          name: element.name,
          total_stock_quantity: element.total_stock_quantity
        }));
      } catch (err) {
        console.error('Error while fetching Items list.');
      }
    },

    getProcedures() {
      axios.get(Api.getProceduresList)
        .then(response => {
          const result = response.data;
          if (result.status === "success") {
            this.proceduresList = result.data.list.map((element) => ({
              id: element.id,
              patient_name: element.patient_name,
              patient_email: element.patient_email,
              procedure_date: element.procedure_date,
              age: element.age,
              gender: element.gender,
              phone_number: element.phone_number,
              cdt_code_name: element?.cdt_code?.name,
              cdt_code_id: element.cdt_code_id,
              procedure_template_id: element.procedure_template_id,
              cdt_code: element?.cdt_code,
              template: element?.template,
              action: ''
            }));
            this.dataLoad = true;
          } else {
            this.$swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
            });
          }
        }).catch(error => {
        console.error('Error fetching procedures list:', error);
      })
    },

    toLocalISOString(date) {
      const timezoneOffsetMs = date.getTimezoneOffset() * 60000;
      const localDate = new Date(date.getTime() - timezoneOffsetMs);
      const formattedDate = localDate.toISOString().split('T')[0];
      const formattedTime = localDate.toISOString().split('T')[1].slice(0, 5);
      return `${formattedDate}T${formattedTime}`;
    },

    createProcedure() {
      this.showModal = true;
      this.selectedProcedure = {
        patient_name: '',
        patient_email: '',
        gender: '',
        age: '',
        phone_number: '',
        procedure_date: this.toLocalISOString(new Date()),
        cdt_code_id: '',
        cdt_code_with_template: '',
        procedure_template_id: '',
      };
      this.config = { title: 'Create Procedure', action: 'create' };
    },

    bookProcedure(procedureData) {
      axios.post(Api.createProcedure, procedureData)
        .then(response => {
          const result = response.data;
          if (result.status === "success") {
            this.$swal.fire({
              icon: "success",
              title: "Item...",
              text: "Procedure Created!",
            }).then(() => {
              this.dataLoad = false;
              this.getProcedures();
              this.showModal = false;
              this.procedureOverviewModalShow = false;
            });
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: 'Error encountered while creating procedure.',
            });
          }
        }).catch(error => {
          this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: error.response.data.message,
          });
          this.showModal = false;
          this.procedureOverviewModalShow = false;
          console.error("Error encountered while creating procedure:", error);
        })
    },

    updateProcedure(row) {
      this.selectedProcedure = { ...row };
      this.selectedProcedure.id = row.id;
      this.selectedProcedure.cdt_code_with_template = row.cdt_code_id + '_' + row.procedure_template_id
      this.config = { title: 'Update Procedure', action: 'create' };
      this.showModal = true;
    },

    updateProcedureDetails(selectedProcedure, procedureId) {
      axios.post(`${Api.updateProcedure}/${procedureId}`, selectedProcedure)
        .then(response => {
          const result = response.data;
          if (result.status === "success") {
            this.$swal.fire({
              icon: "success",
              title: "Procedure...",
              text: "Procedure Updated!",
            }).then(() => {
              this.dataLoad = false;
              this.getProcedures();
              this.showModal = false;
              this.procedureOverviewModalShow = false;
            });
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: 'Error encountered while creating procedure.',
            });
          }
        }).catch(error => {
          this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: error.response.data.message,
          });
          this.showModal = false;
          this.procedureOverviewModalShow = false;
          console.error("Error encountered while updating procedure:", error);
        })
    },

    deleteProcedure(procedureId) {
      this.$swal
        .fire({
          title: "Are you sure?",
          text: "Do you really want to delete procedure? This action cannot be undone.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(`${Api.deleteProcedure}/${procedureId}`)
              .then((response) => {
                const result = response.data;
                if (result.status === "success") {
                  this.$swal
                    .fire({
                      icon: "success",
                      title: "Procedure Deleted",
                      text: "The Procedure has been successfully deleted.",
                    })
                    .then(() => {
                      this.dataLoad = false;
                      this.getProcedures();
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

    handleFilter() {

    },

    closeModal() {
      this.showModal = false
    },

    getItemQuantity(cdtCodeId, procedureTemplateId) {
      let items = [];

      for (const code of this.cdtCodesList) {
        if (code.id == cdtCodeId) {
          for (const template of code.procedure_templates) {
            if (template.id == procedureTemplateId) {
              for (const templateItem of template.templateItems) {
                items.push({
                  itemId: templateItem.item_id,
                  quantity: templateItem.quantity,
                  name: templateItem.item.name,
                })
              }
            }
          }
        }
      }
      return items;
    },

    handleSubmit(selectedProcedure) {
      this.procedureOverviewData = {
        id: selectedProcedure?.id,
        patientName: selectedProcedure.patient_name,
        patientEmail: selectedProcedure.patient_email,
        gender: selectedProcedure.gender,
        age: parseInt(selectedProcedure.age),
        phoneNumber: selectedProcedure.phone_number,
        procedureDate: selectedProcedure.procedure_date,
        cdtCodeId: selectedProcedure.cdt_code_id,
        procedureTemplateId: selectedProcedure.procedure_template_id,
        procedureItems: this.getItemQuantity(selectedProcedure.cdt_code_id, selectedProcedure.procedure_template_id),
      }
      console.log('this.procedureOverviewModalShow',this.procedureOverviewData);
      this.procedureOverviewModalShow = true
    },

    handleFinalSubmit(selectedProcedure) {
      if (!selectedProcedure.id){
        if(!selectedProcedure.patientName) return;
        this.bookProcedure(selectedProcedure);
      } else {
        this.updateProcedureDetails(selectedProcedure, selectedProcedure.id);
      }
    }
  }
}
</script>
