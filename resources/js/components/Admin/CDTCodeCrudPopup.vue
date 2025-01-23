<template>
  <div class="modal-overlay pop-modal-filed" v-if="visible">
    <div class="modal-content">
      <h4 class="text-center font-bold mb-4">{{ config.title }}</h4>
      <!-- Form Fields -->
      <form @submit.prevent="submitForm">
        <div class="form-group row mb-3">
          <div>
            <input v-model="cdtCodes.name" type="text" id="name" class="form-control border rounded-0 f-size" placeholder="Enter CDT Code" required/>
          </div>
        </div>
        <div class="form-group row mb-3">
          <div>
            <textarea v-model="cdtCodes.description" type="text" id="description" class="form-control border rounded-0 f-size" placeholder="CDT Code Description"></textarea>
          </div>
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
        <div class="row action_btn mt-5">
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
export default {
  name: "CDTCodesCRUDPopup",
  props: {
    visible: { type: Boolean, required: true },
    config: {
      type: Object,
      required: true,
      default: () => ({
        title: "Create cdtCodes",
        action: "create",
      }),
    },
    CDTCodesData: {
      type: Object,
      default: () => ({
        name: "",
        description: "",
      }),
    },
  },
  data() {
    return {
      cdtCodes: { ...this.CDTCodesData },
      status: (this.CDTCodesData.status || "active").toLowerCase(),
    };
  },
  watch: {
    CDTCodesData: {
      handler(newData) {
        this.cdtCodes = { ...newData };
        this.status = (newData.status || "active").toLowerCase();
      },
      deep: true,
      immediate: true,
    },
    visible(newVal) {
      if (newVal) {
        this.cdtCodes = { ...this.CDTCodesData };
        this.status = (this.CDTCodesData.status || "active").toLowerCase();
      }
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
    submitForm() {
      const submittedData = { ...this.cdtCodes };
      if (this.config.action === "update") {
        submittedData.status = this.status === 'active';
      }
      if (submittedData.status === 'Active') {
        submittedData.status=true;
      }
      this.$emit("submit", submittedData);
      this.closeModal();
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
  background: #fff;
  padding: 30px;
  border-radius: 8px;
  width: 600px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  max-height: 90vh;
  -webkit-overflow-scrolling: touch;
}
.font-bold {
  font-weight: 600;
}
</style>

