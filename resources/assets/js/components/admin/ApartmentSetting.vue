
<template>
  <div class="text-left">
    <div class="form-group">
      <router-link to="/" class="btn btn-success">Back</router-link>
      <router-link
        :to="{ name: 'apartList' }"
        class="btn btn-default pull-right"
        >Apartment List</router-link
      >
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">Apartment Page</div>
      <div class="panel-body">
        <form v-on:submit.prevent="saveForm()">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Add Apartment Number</label>
              <input
                type="text"
                v-model="company.number"
                class="form-control"
                placeholder="Example 1302b"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Phone Number</label>
              <!-- <input
                type="text"
                v-model="company.phone"
                class="form-control"
                placeholder="Example 0414 556 390"
              /> -->
              <VuePhoneNumberInput
                default-country-code="AU"
                v-model="company.phone"
                :only-countries="only_countries"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Pin Code</label>
              <input
                type="text"
                v-model="company.pin"
                class="form-control"
                placeholder="1234"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group text-right">
              <button class="btn btn-success">Add apartment</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";

export default {
  components: {
    VuePhoneNumberInput,
  },
  data: function () {
    return {
      company: {
        number: "",
        pin: "",
        phone: "",
      },
      only_countries: ["AU"],
    };
  },
  methods: {
    saveForm() {
      var app = this;
      var newCompany = app.company;
      newCompany.phone = this.parsePhone(newCompany.phone);
      axios
        .post("/api/v1/aparts", newCompany)
        .then((resp) => {
          console.log(resp);
          this.$toast.success({
            title: "Success",
            message: "Created apartment.",
            showMethod: "slideInRight",
          });
        })
        .catch(function (resp) {
          console.log(resp);
          //alert("Could not create your company");
        });
    },
  },
};
</script>
