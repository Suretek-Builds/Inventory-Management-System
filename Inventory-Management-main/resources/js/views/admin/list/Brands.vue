<template>
  <div class="table-datadesign">
    <div class="row top-sction">
      <div class="row header-row dashboard-row mb-4">
        <div class="col-md-6">
          <h4 class="headline-font">
            <img src="/images/diamond.png" class="site-icons"> Brand List
          </h4>
        </div>
        <div class="col-md-6 text-end">
          <div class="action_btn">
            <button @click="createBrands" type="button" class="btn btn-primary">
              <i class="fa fa-plus" aria-hidden="true"></i> Create
            </button>
          </div>
        </div>
      </div>

      <!-- Data Table with Filter -->
      <DataTableFilter
        v-if="dataLoad"
        :data="brandsList"
        :columns="columns"
        :showDateFilter="false"
        @filter-applied="handleFilter"
        :searching="true">
        <template #action="{ row }">
          <i :id="row.id" class="fa fa-edit cursor-pointer me-2 f-icon" @click="updateBrand(row)"></i>&nbsp;
          <i :id="row.id" class="fas fa-trash-alt cursor-pointer me-2 f-icon" @click="deleteBrand(row.id)"></i>
        </template>
      </DataTableFilter>
      <BrandCRUDPopup
        :visible="showModal"
        :config="config"
        :BrandData="selectedBrand"
        @close="closeModal"
        @submit="handleSubmit" />
    </div>
  </div>
</template>

<script>
import BrandCRUDPopup from "@/components/Admin/BrandCRUDPopup.vue";
import DataTableFilter from "@/components/includes/DataTableFilter.vue";
import { Api } from "@/api/api.js";
import axios from "axios";

export default {
  name: 'Brands List',

  components: {
    DataTableFilter,
    BrandCRUDPopup
  },

  data() {
    return {
      config: {
        title: 'Create Brand',
        action: 'create',
      },
      brandsList: [],
      columns: [
        { key: 'name', label: 'Name' },
        { key: 'description', label: 'Description' },
        { key: 'action', label: 'Action' },
      ],
      showModal: false,
      dataLoad: false,
      selectedBrand: { name: '', description: '' },
    };
  },

  created() {
    this.getBrandsList()
  },

  methods: {
    getBrandsList() {
      axios.get(Api.getBrandsList)
        .then(response => {
          const result = response.data;
          if (result.status === "success") {
            this.brandsList = result.data.list.map((element) => ({
              id: element.id,
              name: element.name,
              description: element.description,
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
        })
        .catch(error => {
          console.error('Error fetching brands data:', error);
        })
    },
    createBrands() {
      this.showModal = true;
      this.selectedBrand = { name: '', description: '' };
      this.config = { title: 'Create Brand', action: 'create' };
    },
    closeModal() {
      this.showModal = false;
    },
    handleFilter(filterData) {
      console.log('Filter applied:', filterData);
    },
    createNewBrand(createdData) {
      axios
        .post(Api.createBrand,
          createdData,
        )
        .then((response) => {
          const result = response.data;

          if (result.status === "success") {
            this.$swal.fire({
              icon: "success",
              title: "Brand...",
              text: "New Brand Created!",
            }).then(() => {
              this.dataLoad = false;
              this.getBrandsList();
            });
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: 'Brand with the same name already exists',
            });
          }
        })
        .catch((error) => {
          console.error("Error fetching folder data:", error);
        });
    },
    handleSubmit(selectedBrand) {
      if (!selectedBrand.name) return;
      if (!selectedBrand.id) {
        this.createNewBrand(selectedBrand);
      } else {
        this.updateBrandData(selectedBrand,selectedBrand.id);
      }
    },
    updateBrand(row){
      const mappedRow = {
        id: row.id,
        name: row.name,
        description: row.description,
        action: row.action
      };
      this.selectedBrand = { ...mappedRow };
      this.config = { title: "Update Brand", action: "update" };
      this.showModal = true;
    },
    updateBrandData(updateData, id) {
      axios
        .post(`${Api.updateBrand}/${id}`, updateData)
        .then((response) => {
          const result = response.data;
          if (result.status === "success") {
            this.$swal
              .fire({
                icon: "success",
                title: "Success",
                text: "Brand updated successfully!",
              })
              .then(() => {
                this.dataLoad = false;
                this.getBrandsList();
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
    deleteBrand(id) {
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
              .delete(`${Api.deleteBrand}/${id}`)
              .then((response) => {
                const result = response.data;
                if (result.status === "success") {
                  this.$swal
                    .fire({
                      icon: "success",
                      title: "Brand Deleted",
                      text: "The brand has been successfully deleted.",
                    })
                    .then(() => {
                      this.dataLoad = false;
                      this.getBrandsList();
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
<style scoped>
</style>
