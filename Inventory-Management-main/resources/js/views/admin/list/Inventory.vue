<template>
  <div class="table-datadesign">
    <div class="row top-sction">
      <div class="row header-row dashboard-row mb-4">
        <div class="col-md-6">
          <h4 class="headline-font">
            <img src="/images/product-management.png" class="site-icons"> Inventory List
          </h4>
        </div>
        <div class="col-md-6 text-end">
          <div class="action_btn">
            <div class="dropdown">
              <button class="btn btn-primary dropdown-toggle action_btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Restock Items
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" @click="restockItem('all')">All Items (Qty - 100)</a></li>
                <li><a class="dropdown-item" href="#" @click="restockItem('low_stock')">Only Low Stocked Items</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="new-datatableshow tabel-resign">
        <CSmartTable
          cleaner
          :columns="columns"
          columnSorter
          clickableRows
          :items="itemsInventoryList"
          :itemsPerPage="10"
          itemsPerPageSelect
          pagination
          sorter: false
          :tableBodyProps="{
            className: 'align-middle inventory-table',
          }"
          tableFilter
          :tableProps="{
              striped: true,
              hover: true,
            }"
        >
          <template #total_stock_quantity="{ item }">
            <td>
              <p class="row">
                <span class="col-3">{{ item.total_stock_quantity }}</span>
                <template v-if="
              item.total_stock_quantity < item.threshold_quantity
              && item.total_stock_quantity < 0">
                  <span class="col-6 aligntext text-center badge rounded-pill bg-danger">
                    Out of stock
                  </span>
                </template>
                <template v-else-if="item.total_stock_quantity < item.threshold_quantity">
                  <span class="col-6 aligntext text-center badge rounded-pill bg-warning">
                    Low Stock
                  </span>
                </template>
              </p>
            </td>
          </template>
          <template #created_at="{ item }">
            <td>
              {{ this.formatDate(item.created_at) }}
            </td>
          </template>
          <template #show_details="{ item, index }">
            <td class="py-2">
              <CButton class="show-btn"
                       color="primary"
                       variant="outline"
                       square
                       size="sm"
                       @click="this.toggleDetails(item, index)"
              >
                {{ this.details.includes(item._id) ? '-' : '+' }}
              </CButton>
            </td>
          </template>
          <template #details="{ item }">
            <CCollapse :visible="details.includes(item._id)">
              <table class="table datatable table-striped table-hover tabel-resign table-bordered dataTable">
                <thead>
                <tr>
                  <th>Batch Id</th>
                  <th>Quantity</th>
                  <th>Type</th>
                  <th>Description</th>
                  <th>Created At</th>
                  <th>Expire At</th>
                </tr>
                </thead>
                <tbody>
                <template
                  v-for="inventory in item.inventories"
                  :key="inventory.id"
                >
                  <tr>
                    <td>{{ inventory.batch_id }}</td>
                    <td>{{ inventory.quantity }}</td>
                    <td>{{ inventory.type }}</td>
                    <td>{{ inventory.description }}</td>
                    <td>{{ inventory.created_at }}</td>
                    <td>{{ inventory.expire_at }}</td>
                  </tr>
                </template>
                </tbody>
              </table>
            </CCollapse>
          </template>
        </CSmartTable>
      </div>
    </div>
  </div>
</template>

<script>

import { ref } from 'vue';
import { CBadge } from '@coreui/vue-pro';
import { CButton } from '@coreui/vue-pro';
import { CCollapse } from '@coreui/vue-pro';
import { CSmartTable } from '@coreui/vue-pro';
import { Api } from "@/api/api.js";

export default {
  name: 'Inventory',

  components: {
    CBadge,
    CButton,
    CCollapse,
    CSmartTable,
  },

  data() {
    return {
      details: ref([]),
      columns: [
        {
          key: 'name',
          label: 'Item Name',
          _style: {width: '20%'},
          sorter: false
        },
        {
          key: 'brand_name',
          label: 'Brand',
          sorter: false
        },
        {
          key: 'total_stock_quantity',
          label: 'Total Stock',
          sorter: false
        },
        {
          key: 'threshold_quantity',
          label: 'Minimum Inventory',
          sorter: false
        },
        {
          key: 'created_at',
          sorter: false
        },
        {
          key: 'show_details',
          label: '',
          _style: {width: '1%'},
          filter: false,
          sorter: false,
        },
      ],
      itemsInventoryList: [],
      dataLoad: false,
    }
  },

  created() {
    this.getInventoryList();
  },

  methods: {
    getInventoryList() {
      axios.get(Api.getInventoryList)
        .then(response => {
          let result = response.data

          if (result.status === "success") {
            this.itemsInventoryList = result.data.list.map((item) => ({
              id: item.id,
              name: item.name,
              brand_id: item.brand_id,
              brand_name: item.brand.name,
              total_stock_quantity: item.total_stock_quantity,
              threshold_quantity: item.threshold_quantity,
              inventories: item.inventories,
              created_at: item.created_at,
            }));
            this.dataLoad = true;
          } else {
            this.$swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
            });
          }
        }).catch(error => {})
    },

    formatDate(date) {
      const _date = new Date(date)
      const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      }

      return _date.toLocaleDateString('en-US', options)
    },

    toggleDetails(item) {
      if (this.details.includes(item._id)) {
        this.details = this.details.filter((_item) => _item !== item._id)
        return
      }
      this.details.push(item._id)
    },

    restockItem(type) {
      axios.post(Api.restockItem, {
        type: type
      })
        .then(response => {
          let result = response.data

          if (result.status === "success") {
            this.$swal.fire({
              icon: 'success',
              text: 'Items Restocked',
            });

            this.getInventoryList();
          } else {
            this.$swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
            });
          }
        }).catch(error => {})
    }
  }
}
</script>

<style scoped>
.show-btn{
  background: #5856d6;
  color: #fff;
  border: 1px solid #5856d6;
  font-weight: 600;
  font-size: 14px;
  padding: 2px 8px;
}

.show-btn:hover{  background: #4b49b6;
  color: #fff;
  border: 1px solid #4b49b6;}


.new-datatableshow  .page-item{
  cursor: pointer!important;
}

ul.pagination .page-item.active button {
  background: #116aef !important;
}

.active>.page-link, .page-link.active{ background: #116aef !important;}

</style>
