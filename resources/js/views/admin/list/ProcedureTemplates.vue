<template>
  <div class="table-datadesign">
    <div class="row top-sction">
      <div class="row header-row dashboard-row mb-4">
        <div class="col-md-6">
          <h4 class="headline-font">
            <img src="/images/layout.png" class="site-icons" /> Procedures
            Templates List
          </h4>
        </div>
        <div class="col-md-6 text-end">
          <div class="action_btn">
            <button
              @click="createProcedureTemplate"
              type="button"
              class="btn btn-primary"
            >
              <i class="fa fa-plus" aria-hidden="true"></i> Create
            </button>
          </div>
        </div>
      </div>

      <!-- Data Table with Filter -->
      <DataTableFilter
        v-if="dataLoad"
        :data="procedureTemplatesList"
        :columns="columns"
        :showDateFilter="false"
        @filter-applied="handleFilter"
        :searching="true"
      >
        <template #action="{ row }">
          <i
            :id="row.id"
            class="fa fa-edit cursor-pointer me-2 f-icon"
            @click="updateTemplate(row)"
          ></i
          >&nbsp;
          <i
            :id="row.id"
            class="fas fa-trash-alt cursor-pointer me-2 f-icon"
            @click="deleteTemplate(row.id)"
          ></i>
          <i
            class="fas fa-eye cursor-pointer me-2 f-icon"
            @click="viewItems(row.templateItems)"
          ></i>
        </template>
      </DataTableFilter>
      <ProcedureTemplateCrudPopup
        :visible="showModal"
        :config="config"
        :templateData="selectedTemplate"
        @close="closeModal"
        @submit="handleSubmit"
      />
    </div>

    <div class="modal-overlay" v-if="visibleItem">
      <div class="modal-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="text-center font-bold mb-0 flex-grow-1">Item Details</h4>
          <i class="fas fa-close cursor-pointer" @click="closeItemsView"></i>
        </div>
        <div class="row mb-3">
          <div class="row">
            <div class="col-md-6">
              <label class="label-style mb-2">Items Name</label>
            </div>
            <div class="col-md-6">
              <label class="label-style mb-2">Items Quantity</label>
            </div>
          </div>
          <!-- Loop through items -->
          <div
            class="row mb-3 align-items-center"
            v-for="(item, index) in visibleItemData"
            :key="index"
          >
            <!-- Item Name -->
            <div class="col-md-6">
              <input type="text" :id="'name-' + index" class="form-control border rounded-0 f-size"  v-model="item.item.name" :placeholder="'Enter Name for Item ' + (index + 1)" readonly />
            </div>
            <!-- Item Quantity -->
            <div class="col-md-6">
              <input type="number" :id="'quantity-' + index"  class="form-control border rounded-0 f-size" v-model="item.quantity" :placeholder="'Enter Quantity for Item ' + (index + 1)" readonly  />
            </div>
          </div>
        </div>

      </div>
    </div>


  </div>
</template>

<script>
import { Api } from "@/api/api.js";
import axios from "axios";
import DataTableFilter from "@/components/includes/DataTableFilter.vue";
import ProcedureTemplateCrudPopup from "../../../components/Admin/ProcedureTemplateCrudPopup.vue";

export default {
  name: "Procedure Templates",

  components: { DataTableFilter, ProcedureTemplateCrudPopup },

  created() {
    this.getProcedureTemplates();
  },

  data() {
    return {
      visibleItem: false,
      visibleItemData: [],
      config: {
        title: "Create Template",
        action: "create",
      },
      procedureTemplatesList: [],
      columns: [
        { key: "name", label: "Name" },
        { key: "cdt_code", label: "CDT Code" },
        { key: "cdt_code_id", label: "CDT Code Id", hidden: true },
        { key: "templateItems", label: "Template Items", hidden: true },
        { key: "description", label: "Description" },
        { key: "status", label: "Status" },
        { key: "action", label: "Action" },
      ],
      showModal: false,
      dataLoad: false,
      selectedTemplate: { name: "", cdt_code: "", description: "", status: "", templateItems: [], cdt_code_id: '' },
    };
  },

  methods: {
    viewItems(row) {
      if (row.length != 0){
        this.visibleItem = true;
        this.visibleItemData =row;
      } else {
        this.$swal.fire({
          icon: 'alert',
          title: 'Oops...',
          text: 'No Related Item Data Fount!',
        });
      }
    },
    closeItemsView() {
      this.visibleItem = false; // Add a method to hide the modal
    },

    getProcedureTemplates() {
      axios.get(Api.getProcedureTemplatesList)
        .then(response => {
          const result = response.data;
          if (result.status === "success") {
            this.procedureTemplatesList = result.data.list.map((item) => ({
              id: item.id,
              name: item.name,
              description: item.description,
              cdt_code: item.cdt_code.name,
              cdt_code_id:item.cdt_code.id,
              templateItems: item.templateItems,
              status: item.is_active ? 'Active' : 'Inactive',
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
      })
    },
    createProcedureTemplate() {
      this.showModal = true;
      this.selectedTemplate = {
        name: '',
        cdt_code: '',
        cdt_code_id: '',
        description: '',
        status: 'Active',
        templateItems: [
          {
            item: {
              id: ''
            },
            quantity: 1,
          },
        ],
      };
      this.config = { title: 'Create Procedure Template', action: 'create' };
    },
    closeModal() {
      this.showModal = false;
    },
    updateTemplate(row){
      this.selectedTemplate = {
        ...row,
        templateItems: row.templateItems
      };
      this.config = { title: "Update Procedure Template", action: "update" };
      this.showModal = true;
    },
    handleFilter(filterData) {
      console.log('Filter applied:', filterData);
    },
    createNewTemplate(createdData) {
      axios
        .post(Api.createProcedureTemplate, createdData)
        .then((response) => {
          const result = response.data;
          if (result.status === "success") {
            this.$swal
              .fire({
                icon: "success",
                title: "Success",
                text: "New Procedure Template Created!",
              })
              .then(() => {
                this.dataLoad = false;
                this.getProcedureTemplates();
              });
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Procedure Template Already Exist!",
            });
          }
        })
        .catch((error) => {
          console.error("Error creating data:", error);
        });
    },
    updateTemplateData(updateData, id) {
      axios
        .post(`${Api.updateProcedureTemplate}/${id}`, updateData)
        .then((response) => {
          const result = response.data;
          if (result.status === "success") {
            this.$swal
              .fire({
                icon: "success",
                title: "Success",
                text: "Procedure Template updated successfully!",
              })
              .then(() => {
                this.dataLoad = false;
                this.getProcedureTemplates();
              });
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Error",
              text: result.message || "An error occurred while updating the brand.",
            });
          }
        })
        .catch((error) => {
          console.error("Error updating brand data:", error);
          this.$swal.fire({
            icon: "error",
            title: "Error",
            text: "An unexpected error occurred. Please try again later.",
          });
        });
    },
    deleteTemplate(id) {
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
              .delete(`${Api.deleteProcedureTemplate}/${id}`)
              .then((response) => {
                const result = response.data;
                if (result.status === "success") {
                  this.$swal
                    .fire({
                      icon: "success",
                      title: "Procedure Template Deleted",
                      text: "The Procedure Template has been successfully deleted.",
                    })
                    .then(() => {
                      this.dataLoad = false;
                      this.getProcedureTemplates();
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
    handleSubmit(selectedTemplate) {
      if (!selectedTemplate.name) return;
      if (!selectedTemplate.id) {
        let mappedRow = {
          cdt_code: selectedTemplate.cdt_code_id,
          name: selectedTemplate.name,
          description: selectedTemplate.description,
          status: selectedTemplate.status,
          templateItems: selectedTemplate.templateItems,
          cdt_code_id: selectedTemplate.cdt_code_id
        };
        this.createNewTemplate(mappedRow);
      } else {
        console.log('selectedTemplate',selectedTemplate);
        this.updateTemplateData(selectedTemplate, selectedTemplate.id);
      }
    }
  },
};
</script>
<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  overflow: auto;
  background: #fff;
  padding: 30px;
  border-radius: 8px;
  width: 600px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  max-height: 80vh;
  -webkit-overflow-scrolling: touch;
}

.modal-content::-webkit-scrollbar {
  width: 0px;
  background: transparent;
}

.modal-content {
  scrollbar-width: none;
}

.font-bold {
  font-weight: 600;
}

select {
  appearance: auto;
  -webkit-appearance: auto;
  -moz-appearance: auto;
}
</style>
