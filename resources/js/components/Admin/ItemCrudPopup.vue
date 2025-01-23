<template>
  <div class="modal-overlay pop-modal-filed" v-if="visible">
    <div class="modal-content">
      <h4 class="text-center font-bold mb-4">{{ config.title }}</h4>
      <!-- Form Fields -->
      <form @submit.prevent="submitForm">
        <div class="form-group mb-3">
          <label for="branddata" class="label-style mb-3">Select Brand</label>
          <select v-model="item.brand_id" class="form-control rounded-0 f-size" required>
            <option disabled value="">Select Brand</option>
            <option v-for="data in brandData" :key="data.id" :value="data.id">
              {{ data.name }}
            </option>
          </select>
        </div>
        <div class="form-group row mb-3">
          <label for="name" class="label-style text-md-start mb-2">Name</label>
          <div>
            <input v-model="item.name" type="text" id="name" class="form-control border rounded-0 f-size" placeholder="Item Name" required/>
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="thresholdquantity" class="label-style text-md-start mb-2">Minimum Inventory</label>
          <div>
            <input v-model="item.threshold_quantity" type="text" id="thresholdquantity" class="form-control border rounded-0 f-size" placeholder="Item minimum inventory" required>
          </div>
        </div>
        <div class="form-group row mb-3">
          <label for="description" class="label-style text-md-start mb-2">Description</label>

          <div>
            <textarea v-model="item.description" type="text" id="description" class="form-control border rounded-0 f-size" placeholder="Item Description"></textarea>
          </div>
          <!-- Action Buttons -->
          <div class="row action_btn mt-5">
            <div class="col-6 text-end">
              <button type="button" @click="closeModal" class="btn btn-secondary close-btn">Cancel</button>
            </div>
            <div class="col-6">
              <button type="submit" class="btn btn-primary save-btn">Save</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Api } from "@/api/api.js";
import axios from "axios";
export default {
  name: "itemCRUDPopup",
  props: {
    visible: { type: Boolean, required: true },
    config: {
      type: Object,
      required: true,
      default: () => ({
        title: "Create item",
        action: "create",
      }),
    },
    itemData: {
      type: Object,
      default: () => ({
        name: "",
        description: "",
      }),
    },
  },
  data() {
    return {
      item: { ...this.itemData },
      brandData:[],
    };
  },
  watch: {
    itemData: {
      handler(newData) {
        this.item = { ...newData };
      },
      deep: true,
      immediate: true,
    },
    visible(newVal) {
      if (newVal) {
        this.getBrandsList();
        this.item = { ...this.itemData };
      }
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
    submitForm() {
      const submittedData = { ...this.item };
      this.$emit("submit", submittedData);
      this.closeModal();
    },
    getBrandsList() {
      axios.get(Api.getBrandsList)
        .then(response => {
          const result = response.data;
          if (result.status === "success" && result.data.list.length > 0) {
            this.brandData = result.data.list || [];
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
  max-height: 90vh;
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
