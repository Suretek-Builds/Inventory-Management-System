<template>
  <div class="modal-overlay pop-modal-filed stcy-btn" v-if="visible">
    <div class="modal-content">
      <h4 class="text-center font-bold mb-4">{{ config.title }}</h4>
      <!-- Form Fields -->
      <form @submit.prevent="submitForm" class="pd-form">
        <div class="form-group row mb-3">
          <label for="name" class="label-style text-md-start mb-2">Template Name</label>
          <div>
            <input v-model="template.name" type="text" id="name" class="form-control border rounded-0 f-size" placeholder="Template Name" :readonly="config.action === 'update'" required />
          </div>
        </div>

        <div class="form-group mb-3">
          <label for="cdtCodeData" class="label-style mb-3">Select CDT Code</label>
          <select v-model="template.cdt_code_id" class="form-control rounded-0 f-size" required>
            <option disabled value="">Select CDT Code</option>
            <option v-for="data in cdtCodeData" :key="data.id" :value="data.id">
              {{ data.name }}
            </option>
          </select>
        </div>

        <div class="form-group row mb-3">
          <label for="description" class="label-style text-md-start mb-2">Description</label>
          <div>
            <textarea v-model="template.description" id="description" class="form-control border rounded-0 f-size" placeholder="Template Description" required></textarea>
          </div>
        </div>

        <!-- Dynamic Items Section -->
        <div >
          <div
            v-for="(item, index) in filteredTemplateItems"
            :key="item.item.id"
            class="d-flex align-items-center mb-2"
          >
          <div class="reflex-close">
            <div class="row">
              <div class="col-md-6">
            <select
              v-model="item.item.id"
              class="form-control me-2"
              required
            >
              <option disabled value="">Select Item</option>
              <option
                v-for="option in filteredItems(index)"
                :key="option.id"
                :value="option.id"
              >
                {{ option.name }}
              </option>
            </select>
          </div>
          <div class="col-md-6">
            <input
              v-model="item.quantity"
              type="number"
              class="form-control me-0"
              placeholder="Quantity"
              required
            />
            <button
              v-if="index > 0"
              type="button"
              class="btn btn-danger min-btn"
              @click="removeItem(item.item.id)"
            >
              x
            </button>

          </div>
          </div>
          </div>
        </div>
          <button type="button" class="btn btn-primary add-item-btn" @click="addItem">Add Item</button>
        </div>

        <!-- Status Section -->
        <div v-if="config.action === 'update'">
          <label for="status" class="label-style text-md-start mb-2">Status</label>
          <div class="form-group mb-3 d-flex gap-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" id="statusActive" value="active" v-model="status" />
              <label class="form-check-label" for="statusActive">Active</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" id="statusInactive" value="inactive" v-model="status" />
              <label class="form-check-label" for="statusInactive">Inactive</label>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="row action_btn sticky-bottom py-2 bg-white pt-2 pb-2">
          <div class="col-6 text-end">
            <button type="button" @click="closeModal" class="btn btn-secondary close-btn">Cancel</button>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-primary save-btn">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Api } from "@/api/api.js";
import axios from "axios";
import cdtCodes from "@/composables/cdtCodes";

export default {
  name: "TemplateCRUDPopup",
  props: {
    visible: { type: Boolean, required: true },
    config: {
      type: Object,
      required: true,
      default: () => ({
        title: "Create template",
        action: "create",
      }),
    },
    templateData: {
      type: Object,
      default: () => ({
        name: "",
        description: "",
      }),
    },
  },
  data() {
    return {
      template: {
        name: this.templateData.name || "",
        description: this.templateData.description || "",
        templateItems: []
      },
      status: (this.templateData.status || "active").toLowerCase(),
      cdtCodeData: [],
      availableItems: [],
    };
  },
  watch: {
    templateData: {
      handler(newData) {
        if (newData) {
          this.template.name = newData.name || this.template.name;
          this.template.description = newData.description || this.template.description;
          this.template.cdt_code = newData.cdt_code || this.template.cdt_code;      }
      },
      deep: true,
      immediate: true,
    },
    visible(newVal) {
      if (newVal) {
        this.getCdtCodeList();
        this.getAvailableItems();
        this.template = { ...this.templateData };
        this.status = (this.templateData.status || "active").toLowerCase();
      }
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
    submitForm() {
      const submittedData = { ...this.template };
      if (this.config.action === "update") {
        if(this.status === 'active'){
          submittedData.status = true;
        }else{
          submittedData.status = false;
        }
      }
      if(submittedData.status === 'Active'){
        submittedData.status=true;
      }
      this.$emit("submit", submittedData);
      this.closeModal();
    },
    async getCdtCodeList() {
      try {
        const cdtCodeService = cdtCodes();
        this.cdtCodeData = await cdtCodeService.getCdtCodeList('all');
      } catch (err) {
        console.error('Error while fetching CDT codes list.');
        this.$swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
        });
      }
    },
    getAvailableItems() {
      axios
        .get(Api.getItemsList)
        .then((response) => {
          const result = response.data;
          if (result.status === "success") {
            this.availableItems = result.data.list || [];
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Failed to fetch items!",
            });
          }
        })
        .catch((error) => {
          console.error("Error fetching available items:", error);
        });
    },
    filteredItems(currentIndex) {
    const selectedItems = this.filteredTemplateItems
      .filter((item, index) => index !== currentIndex && item?.item?.id)
      .map((item) => item.item.id);
      return (this.availableItems || []).filter(
        (option) => !selectedItems.includes(option.id)
      );
    },

    addItem() {
      if (!Array.isArray(this.template.templateItems)) {
        this.template.templateItems = [];
      }
      this.template.templateItems.push({item: {id: ""}, quantity: 1});
    },

    removeItem(itemId) {
      if (Array.isArray(this.template.templateItems)) {
        const itemIndex = this.template.templateItems.findIndex(
          (item) => item.item.id === itemId
        );
        if (itemIndex !== -1) {
          if(itemIndex == 0) return;
          const item = this.template.templateItems[itemIndex];
          if (item.item && item.item.id && item.id) {
            this.template.templateItems[itemIndex].removedItem = item.item.id;
          } else {
            this.template.templateItems.splice(itemIndex, 1);
          }
        }
      }
    },
  },
  computed: {
    filteredTemplateItems() {
      return this.template.templateItems.filter(item => !item.removedItem);
    }
  }

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
