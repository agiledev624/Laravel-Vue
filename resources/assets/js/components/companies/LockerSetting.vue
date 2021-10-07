
<template>
  <div class="text-left">
    <div class="form-group">
      <router-link to="/" class="btn btn-default">Back</router-link>
      <router-link
        :to="{ name: 'lockerList' }"
        class="btn btn-default pull-right"
        >LockerList</router-link
      >
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Apartment Page</div>
      <div class="panel-body">
        <form v-on:submit.prevent="saveForm()">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Comms port for SMS service</label>
              <!-- <select class="form-control">
                <option>Com1</option>
                <option>Com2</option>
                <option>Com3</option>
                <option>Com4</option>
                <option>Com5</option>
              </select> -->
              <input
                type="text"
                v-model="sms.port"
                class="form-control"
                placeholder="port number"
              />
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
                v-model="sms.msg"
                class="form-control"
                placeholder="(apartment Phone number) - a package has arrived for you"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group text-right">
              <button class="btn btn-success">Update</button>
            </div>
          </div>
        </form>

        <form v-on:submit.prevent="addLocker()">
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
              <label class="control-label">Locker number</label>
              <input
                type="text"
                v-model="locker.number"
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
                v-model="locker.code"
                class="form-control"
                placeholder="Example 01 43 A7 B6 22 B5"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">What size is this locker</label>
              <div class="form-check">
                <input
                  @change="onChange($event)"
                  value="0"
                  class="form-check-input"
                  type="radio"
                  name="flexRadioDefault"
                  id="flexRadioDefault1"
                  checked
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
                  @change="onChange($event)"
                  value="1"
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
                  id="flexRadioDefault3"
                  @change="onChange($event)"
                  value="2"
                />
                <label class="form-check-label" for="flexRadioDefault3">
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
      sms: {
        port: "",
        msg: "",
      },
      company: {
        number: "",
        pin: "",
      },
      locker: {
        number: "",
        code: "",
        size: "0",
        port: "1",
        owner: "0",
      },
      selected: "",
    };
  },
  mounted() {
    let app = this;
    axios
      .get("/api/v1/settings/get_sms")
      .then(function (resp) {
        app.sms.port = resp.data.port;
        app.sms.msg = resp.data.msg;
      })
      .catch(function () {
        alert("Could not load your company");
      });
  },
  methods: {
    onChange(event) {
      var data = event.target.value;
      this.locker.size = data;
    },
    saveForm() {
      var app = this;
      var newCompany = app.sms;
      axios
        .post("/api/v1/settings/set_sms", newCompany)
        .then(function (resp) {
          // app.$router.push({ path: "/" });
        })
        .catch(function (resp) {
          console.log(resp);
          alert("Could not create your company");
        });
    },
    addLocker() {
      var app = this;
      var newLocker = app.locker;
      axios
        .post("/api/v1/lockers/add", newLocker)
        .then(function (resp) {
          //app.$router.push({ path: "/" });
          console.log('success');
        })
        .catch(function (resp) {
          console.log(resp);
          alert("Could not add locker");
        });
    },
  },
};
</script>
