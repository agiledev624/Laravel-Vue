
<template>
  <div>
    <!-- <div class="form-group text-left">
      <a @click="$router.go(-1)" class="btn btn-success">Back</a>
    </div> -->
    <!-- 
      // TODO get unique id for the department and include this to the request
      // TODO save the courier number to the database for the identify?
      <p>{{ $route.params.id }}</p> -->
    <div class="panel panel-default text-left">
      <div class="panel-heading">
        <span>Couriers Page</span>
        <span class="pull-right"
          ><strong> Address : {{ address }} </strong></span
        >
      </div>
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
          <vue-recaptcha
            ref="recaptcha"
            @verify="onVerify"
            :sitekey="siteKey"
          ></vue-recaptcha>
          <ul class="alert alert-danger btn--margin" v-if="errors.length != 0">
            <li v-for="error in errors">{{ error[0] }}</li>
          </ul>
          <div class="row">
            <div class="col-xs-12 form-group text-right p-t-10">
              <router-link
                :to="'/foyer/' + company.unique"
                class="btn btn-success pull-left m-t-10"
                >To Access Foyer</router-link
              >
              <VueLoadingButton
                class="btn btn-success btn--margin"
                aria-label="Open"
                @click.native="saveForm"
                :loading="isLoading"
                :styled="false"
                >Open</VueLoadingButton
              >
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import VueRecaptcha from "vue-recaptcha";
import VueLoadingButton from "vue-loading-button";
export default {
  components: { VueRecaptcha, VueLoadingButton },
  data: function () {
    return {
      company: {
        size: "0",
        owner: "",
        recaptcha: "",
        unique: this.$route.params.id,
      },
      siteKey: process.env.MIX_RECAPTCHA_SITE_KEY,
      errors: [],
      isLoading: false,
      address: "",
    };
  },
  mounted() {
    var app = this;
    axios
      .get(`/api/v1/lockers/check_courier/${this.$route.params.id}`)
      .then(function (resp) {
        app.address = resp.data.address;
      })
      .catch(function (resp) {
        console.log(resp);
        //alert("Could not load companies");
      });
  },
  methods: {
    onVerify(response) {
      this.company.recaptcha = response;
    },
    onChange(event) {
      var data = event.target.value;
      this.company.size = data;
    },
    saveForm() {
      var app = this;
      var newCompany = app.company;
      this.errors = [];
      this.isLoading = true;
      axios
        .post("/api/v1/lockers/new_assign", newCompany)
        .then((resp) => {
          console.log(resp);
          this.$refs.recaptcha.reset();
          this.isLoading = false;
          if (resp.data.result == 0) {
            this.$toast.success({
              title: "Success",
              message: `Put your parcel at Locker ${resp.data.locker}. Owner will get notified after lock.`,
              showMethod: "slideInRight",
            });
            app.$router.push({ path: "/thanks" });
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
          console.log(resp.response);
          this.$refs.recaptcha.reset();
          this.isLoading = false;
          // alert("No available locker. Select another size.");
          if (resp.response.data.errors) {
            this.errors = resp.response.data.errors;
          }
          this.$toast.error({
            title: "Error",
            message: resp.response.data.message,
            showMethod: "slideInRight",
          });
        });
    },
  },
};
</script>
<style scoped>
.m-t-10 {
  margin-top: 10px;
}
</style>