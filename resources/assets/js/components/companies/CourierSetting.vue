
<template>
  <div class="text-left">
    <div class="form-group">
      <router-link to="/" class="btn btn-success">Back</router-link>
      <router-link
        :to="{ name: 'courierList' }"
        class="btn btn-default pull-right"
        >Couriers List</router-link
      >
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">Couriers Page</div>
      <div class="panel-body">
        <form v-on:submit.prevent="saveForm()">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Add Courier Name</label>
              <input
                type="text"
                v-model="company.name"
                class="form-control"
                placeholder="Alice"
              />
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Password</label>
              <input
                type="text"
                v-model="company.password"
                class="form-control"
                placeholder="1234"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group text-right">
              <button class="btn btn-success">Add courier</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
// import VuePhoneNumberInput from "vue-phone-number-input";
// import "vue-phone-number-input/dist/vue-phone-number-input.css";

// Vue.component("vue-phone-number-input", VuePhoneNumberInput);

export default {
  // components: {
  //   VuePhoneNumberInput,
  // },
  data: function () {
    return {
      company: {
        name: "",
        password: "",
        user_id: this.$userId,
      },
      phone_select: "",
      only_countries: ["AU"],
    };
  },
  methods: {
    saveForm() {
      var app = this;
      var newCompany = app.company;
      // newCompany.phone = this.parsePhone(newCompany.phone);
      // console.log(newCompany);
      axios
        .post("/api/v1/couriers", newCompany)
        .then((resp) => {
          console.log(resp);
          this.$toast.success({
            title: "Success",
            message: "Created courier.",
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
