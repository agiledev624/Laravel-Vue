
<template>
  <div>
    <div class="form-group text-left">
      <router-link to="/" class="btn btn-default">Back</router-link>
    </div>

    <div class="panel panel-default text-left">
      <div class="panel-heading">Couriers Page</div>
      <div class="panel-body">
        <form v-on:submit.prevent="saveForm()">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label"
                >Apartment Number that your delivery is for</label
              >
              <input type="text" v-model="company.name" class="form-control" />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label"
                >Locker Size you need for your delivery</label
              >
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  name="flexRadioDefault"
                  id="flexRadioDefault1"
                />
                <label class="form-check-label" for="flexRadioDefault1">
                  Small
                </label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  name="flexRadioDefault"
                  id="flexRadioDefault2"
                  checked
                />
                <label class="form-check-label" for="flexRadioDefault2">
                  Medium
                </label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  name="flexRadioDefault"
                  id="flexRadioDefault2"
                  checked
                />
                <label class="form-check-label" for="flexRadioDefault2">
                  Large
                </label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 form-group text-right">
              <button class="btn btn-success">Create</button>
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
        name: "",
        address: "",
        website: "",
        email: "",
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