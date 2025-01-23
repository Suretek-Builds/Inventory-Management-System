<template>
  <div class="table-datadesign">
    <div class="row top-sction">
      <div class="row header-row dashboard-row mb-4">
        <div class="col-md-6">
          <h4 class="headline-font">
            <img src="/images/product-management.png" class="site-icons"> Item List
          </h4>
        </div>
        <div class="col-md-6 text-end">
          <div class="action_btn">
            <button @click="createItem" type="button" class="btn btn-primary">
              <i class="fa fa-plus" aria-hidden="true"></i>  Create
            </button>
          </div>
        </div>
      </div>

      <!-- Data Table with Filter -->
      <DataTableFilter
        v-if="dataLoad"
        :data="itemList"
        :columns="columns"
        :showDateFilter="false"
        @filter-applied="handleFilter"
        :searching="true">
        <template #action="{ row }">
          <i :id="row.id" class="fa fa-edit cursor-pointer me-2 f-icon" @click="updateItem(row)"></i>&nbsp;
          <i :id="row.id" class="fas fa-trash-alt cursor-pointer me-2 f-icon" @click="deleteItem(row.id)"></i>
        </template>
      </DataTableFilter>
      <ItemCrudPopup
        :visible="showModal"
        :config="config"
        :itemData="selectedItem"
        @close="closeModal"
        @submit="handleSubmit" />
    </div>
  </div>
</template>

<script>
import ItemCrudPopup from "@/components/Admin/ItemCrudPopup.vue";
import DataTableFilter from "@/components/includes/DataTableFilter.vue";
import {Api} from "@/api/api.js";
import axios from "axios";
import items from '@/composables/items'

export default {
  name: 'Item List',

  components: {
    DataTableFilter,
    ItemCrudPopup
  },

  data() {
    return {
      config: {
        title: 'Create Item',
        action: 'create',
      },
      itemList: [],
      columns: [
        { key: 'name', label: 'Name' },
        { key: 'brand_name', label: 'Brand Name'},
        { key: 'description', label: 'Description' },
        { key: 'threshold_quantity', label: 'Minimum Inventory'},
        { key: 'brand_id', label: 'Brand Id', hidden: true },
        { key: 'action', label: 'Action' },
      ],
      showModal: false,
      dataLoad: false,
      selectedItem: { name: '', description: '', threshold_quantity:'' },
    };
  },

  created() {
    this.getItemsList()
  },

  methods: {
    async getItemsList() {
      try {
        const itemService = items();
        let itemsList = await itemService.getItemsList();
        this.itemList = itemsList.map(item => ({
          ...item,
          brand_name: item.brand.name
        }));
        this.dataLoad = true;
      } catch (err) {
        this.$swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
        });
      }
    },
    createItem() {
      this.showModal = true;
      this.selectedItem = { name: '', description: '', threshold_quantity:'', brand_id: '' };
      this.config = { title: 'Create Item', action: 'create' };
    },
    closeModal() {
      this.showModal = false;
    },
    handleFilter(filterData) {
      console.log('Filter applied:', filterData);
    },
    createNewItem(createdData) {
      axios
        .post(Api.createItem,
          createdData,
        )
        .then((response) => {
          const result = response.data;
          if (result.status === "success") {
            this.$swal.fire({
              icon: "success",
              title: "Item...",
              text: "New Item Created!",
            }).then(() => {
              this.dataLoad = false;
              this.getItemsList();
            });
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: 'Item Already Exist',
            });
          }
        })
        .catch((error) => {
          console.error("Error fetching folder data:", error);
        });
    },
    handleSubmit(selectedItem) {
      if (!selectedItem.name) return;
      if(!selectedItem.id){
        this.createNewItem(selectedItem);
      }else{
        this.updateItemData(selectedItem,selectedItem.id);
      }
    },
    updateItem(row){
      this.selectedItem = row
      this.config = { title: "Update Item", action: "update" };
      this.showModal = true;
    },
    updateItemData(updateData, id) {
      axios
        .post(`${Api.updateItem}/${id}`, updateData)
        .then((response) => {
          const result = response.data;
          if (result.status === "success") {
            this.$swal
              .fire({
                icon: "success",
                title: "Success",
                text: "Item updated successfully!",
              })
              .then(() => {
                this.dataLoad = false;
                this.getItemsList();
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
    deleteItem(id) {
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
              .delete(`${Api.deleteItem}/${id}`)
              .then((response) => {
                const result = response.data;
                if (result.status === "success") {
                  this.$swal
                    .fire({
                      icon: "success",
                      title: "Item Deleted",
                      text: "The Item has been successfully deleted.",
                    })
                    .then(() => {
                      this.dataLoad = false;
                      this.getItemsList();
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
