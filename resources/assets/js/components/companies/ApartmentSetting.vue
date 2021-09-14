
<template>
  <div class="text-left">
    <div class="form-group">
      <router-link to="/" class="btn btn-default">Back</router-link>
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
              <input
                type="text"
                v-model="company.pin"
                class="form-control"
                placeholder="Example 0414 556 390"
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
export default {
  data: function () {
    return {
      company: {
        number: "",
        pin: "",
      },
    };
  },
  methods: {
    saveForm() {
      var app = this;
      var newCompany = app.company;
      axios
        .post("/api/v1/companies", newCompany)
        .then(function (resp) {
          app.$router.push({ path: "/" });
        })
        .catch(function (resp) {
          console.log(resp);
          alert("Could not create your company");
        });
    },
  },
};
</script>
