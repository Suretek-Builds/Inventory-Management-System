<template>
  <div class="modal-overlay pop-modal-filed" v-if="visible">
    <div class="modal-content">
      <h4 class="text-center font-bold mb-4">Procedure Overview</h4>
      <form @submit.prevent="submitForm">
        <table class="w-100">
         <div class="row">
                <div class="col-md-6">
                  <label>Item Name</label>
              </div>
            <div class="col-md-6">
               <label>Quantity</label>
            </div>
            </div>
          <tbody class="w-100">
          <template v-for="item in procedureDetail.procedureItems">
            <tr>

              <div class="row mt-2">
                <div class="col-md-6">
                  <!-- <label>Item Name</label> -->
                <select v-model="item.itemId" id="procedure_items" class="form-control border rounded-0 f-size" required>
                  <option disabled value="">Select</option>
                  <template v-for="item in itemsList">
                    <option :value="item.id">{{ item.name }}</option>
                  </template>
                </select>
              </div>
            <div class="col-md-6">
               <!-- <label>Quantity</label> -->
              <input type="text" v-model="item.quantity" class="form-control" />
            </div>
            </div>
            </tr>
          </template>
          </tbody>
        </table>
        <!-- Action Buttons -->
        <div class="row action_btn mt-3">
          <div class="col-6 text-end">
            <button type="button" @click="closeModal" class="btn btn-secondary close-btn">
              Cancel</button>
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
  name: 'ProcedureOverview',

  props: {
    procedureDetail: {
      type: Object,
      required: true
    },
    visible: {
      type: Boolean,
      required: true,
      default: false,
    },
    itemsList: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      procedureData: { ...this.procedureDetail },
    };
  },

  watch: {
    procedureDetail: {
      handler(newData) {
        this.procedureData = { ...newData };

        console.log('procedureData ', this.procedureData)
      },
      deep: true,
      immediate: true,
    },
    visible(newVal) {
      if (newVal) {
        this.procedureData = { ...this.procedureDetail };
        console.log('visible procedureData ', this.procedureData)
      }
    },
  },

  methods: {
    closeModal() {
      this.$emit("close");
    },

    submitForm() {
      const submittedData = { ...this.procedureData };
      console.log('submittedData',submittedData);
      this.$emit("submit", submittedData);
    }
  }
}
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
  width: 40%;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  overflow-y:scroll;
  max-height: 80vh;
}
.font-bold {
  font-weight: 600;
}
</style>
