
<template>
  <div>
    <div class="form-group text-left">
      <router-link to="/" class="btn btn-success">Back</router-link>
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
              <input
                type="text"
                v-model="company.owner"
                class="form-control"
                placeholder="1234a"
              />
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
                  @change="onChange($event)"
                  value="0"
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
              <button class="btn btn-success">Open</button>
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
        size: "0",
        owner: "",
      },
    };
  },
  methods: {
    onChange(event) {
      var data = event.target.value;
      this.company.size = data;
    },
    saveForm() {
      var app = this;
      var newCompany = app.company;

      axios
        .post("/api/v1/lockers/new_assign", newCompany)
        .then((resp) => {
          console.log(resp);
          if (resp.data.result == 0) {
            this.$toast.success({
              title: "Success",
              message: "Owner will get notified after lock.",
              showMethod: "slideInRight",
            });
          } else {
            this.$toast.warn({
              title: "Warning",
              message: "No available locker for the size",
              showMethod: "slideInRight",
            });
          }
          // alert(resp.data.message);
        })
        .catch((resp) => {
          console.log(resp);
          // alert("No available locker. Select another size.");
          this.$toast.error({
            title: "Error",
            message: resp.data.message,
            showMethod: "slideInRight",
          });
        });
    },
  },
};
</script>