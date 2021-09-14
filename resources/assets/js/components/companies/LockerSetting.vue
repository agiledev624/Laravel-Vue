
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
              <label class="control-label"
                >Comms Port to use for these lockers</label
              >
              <select class="form-control">
                <option>Com1</option>
                <option>Com2</option>
                <option>Com3</option>
                <option>Com4</option>
                <option>Com5</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Comms port for SMS service</label>
              <select class="form-control">
                <option>Com1</option>
                <option>Com2</option>
                <option>Com3</option>
                <option>Com4</option>
                <option>Com5</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label"
                >RS232 to sms Serial Data to send for text message to alert
                apartments of delivery</label
              >
              <input
                type="text"
                v-model="company.pin"
                class="form-control"
                placeholder="(apartment Phone number) - a package has arrived for you"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group text-right">
              <button class="btn btn-success">Save</button>
            </div>
          </div>
        </form>
        <form v-on:submit.prevent="saveForm()">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Locker number</label>
              <input
                type="text"
                v-model="company.name"
                class="form-control"
                placeholder="Example 1"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">RS232 code to open</label>
              <input
                type="text"
                v-model="company.name"
                class="form-control"
                placeholder="Example 01 43 A7 B6 22 B5"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Waht size is this locker</label>
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
              <button class="btn btn-success">Add</button>
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
