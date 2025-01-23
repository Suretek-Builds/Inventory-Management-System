<template>
  <div class="modal-overlay pop-modal-filed" v-if="visible">
    <div class="modal-content">
      <h4 class="text-center font-bold mb-4">{{ config.title }}</h4>
      <!-- Form Fields -->
      <form @submit.prevent="submitForm">
        <div class="row">
          <div class="form-group mb-3 col-6">
            <label for="patient_name">Patient Name</label>
            <input v-model="procedure.patient_name" type="text" id="patient_name" class="form-control border rounded-0 f-size" placeholder="Enter full name" required/>
          </div>
          <div class="form-group mb-3 col-6">
            <label for="patient_email">Patient Email</label>
            <input v-model="procedure.patient_email" type="text" id="patient_email" class="form-control border rounded-0 f-size" placeholder="Enter email address name" required/>
          </div>
        </div>

        <div class="row">
          <div class="form-group mb-3 col-6">
            <label for="gender">Gender</label>
            <select v-model="procedure.gender" id="gender" class="form-control border rounded-0 f-size" required>
              <option value="">- Select</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="form-group mb-3 col-6">
            <label for="age">Age</label>
            <input v-model="procedure.age" type="text" id="age" class="form-control border rounded-0 f-size" placeholder="Enter age" required/>
          </div>
        </div>

        <div class="row">
          <div class="form-group mb-3 col-6">
            <label for="phone_number">Phone Number</label>
            <input v-model="procedure.phone_number" type="text" id="phone_number" class="form-control border rounded-0 f-size" placeholder="Enter phone number" required/>
          </div>
          <div class="form-group mb-3 col-6">
            <label for="procedure_date">Procedure Date</label>
            <input v-model="procedure.procedure_date" type="datetime-local" id="procedure_date" class="form-control border rounded-0 f-size" required/>
          </div>
        </div>

        <div class="row">
          <div class="form-group mb-3">
            <label for="cdt_code">CDT Code</label>
            <select v-model="procedure.cdt_code_with_template" id="cdt_code" class="form-control border rounded-0 f-size" required>
              <option value="">Select CDT code</option>
              <template v-for="code in cdtCodesList">
                <template v-for="template in code.procedure_templates">
                  <option :value="code.id + '_' + template.id">{{ code.name + ' - ' + template.name + ' - ' + template.description}}</option>
                </template>
              </template>
            </select>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="row action_btn mt-3">
          <div class="col-6 text-end">
            <button type="button" @click="closeModal" class="btn btn-secondary close-btn">
              Cancel</button>
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-primary save-btn" @click="submitForm()">Preview</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProcedureCrudPopup",

  props: {
    visible: {
      type: Boolean,
      required: true
    },
    config: {
      type: Object,
      required: true,
      default: () => ({
        title: "Create Procedure",
        action: "create",
      }),
    },
    procedureData: {
      type: Object,
      default: () => ({
        name: "",
        description: "",
      }),
    },
    cdtCodesList: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      procedure: { ...this.procedureData },
    };
  },
  watch: {
    procedureData: {
      handler(newData) {
        this.procedure = { ...newData };
      },
      deep: true,
      immediate: true,
    },
    visible(newVal) {
      if (newVal) {
        this.procedure = { ...this.procedureData };
      }
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
    submitForm() {
      const submittedData = { ...this.procedure };
      let cdtCodeWithTemplateId = this.procedure.cdt_code_with_template.split('_')
      submittedData.cdt_code_id = cdtCodeWithTemplateId.shift(0)
      submittedData.procedure_template_id = cdtCodeWithTemplateId.pop()
      let procedureTime = this.procedure.procedure_date;
      if (procedureTime.includes('T')) {
          procedureTime = procedureTime.replace('T', ' ') + ":00";
      } else {
          procedureTime = procedureTime;
      }
      submittedData.procedure_date =procedureTime
      console.log('submittedDatapppppp',submittedData)
      this.$emit("submit", submittedData);
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
  width: 40%;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.font-bold {
  font-weight: 600;
}
</style>
