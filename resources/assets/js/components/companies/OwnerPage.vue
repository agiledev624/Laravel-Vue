
<template>
  <div class="text-left">
    <div class="form-group">
      <a @click="$router.go(-1)" class="btn btn-success">Back</a>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Apartment Page</div>
      <div class="panel-body">
        <form v-on:submit.prevent="saveForm()">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Apartment Number</label>
              <input
                type="text"
                v-model="company.number"
                class="form-control"
                placeholder="1302b"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label"
                >Enter 4 digit Pin. Contct building manager if you do not have a
                pin code set up</label
              >
              <input
                type="text"
                v-model="company.pin"
                class="form-control"
                placeholder="1234"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label"
                >Your phone number. Please type without space.</label
              >
              <input
                type="text"
                v-model="company.phone"
                class="form-control"
                placeholder="+61323423422"
              />
            </div>
          </div>
          <vue-recaptcha
            ref="recaptcha"
            @verify="onVerify"
            sitekey="6LeWzwEdAAAAALpTQ7-83nQRNXwTHR6K0k6KOWUS"
          ></vue-recaptcha>
          <ul class="alert alert-danger btn--margin" v-if="errors.length != 0">
            <li v-for="error in errors">{{ error[0] }}</li>
          </ul>
          <div class="row">
            <div class="col-xs-12 form-group text-right">
              <button class="btn btn-success btn--margin">Open</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import VueRecaptcha from "vue-recaptcha";
export default {
  components: { VueRecaptcha },
  data: function () {
    return {
      company: {
        phone: "",
        number: "",
        pin: "",
        recaptcha: "",
      },
      errors: [],
    };
  },
  methods: {
    onVerify(response) {
      this.company.recaptcha = response;
    },
    saveForm() {
      var app = this;
      var newCompany = app.company;
      axios
        .post("/api/v1/lockers/open_lockers", newCompany)
        .then((resp) => {
          //TODO make the recaptcha logic more secure
          this.$refs.recaptcha.reset();

          console.log(resp.data);
          if (resp.data.result == 2) {
            this.$toast.warn({
              title: "Notification",
              message: "No parcels arrived.",
              showMethod: "slideInRight",
            });
          } else if (resp.data.result == 3) {
            this.$toast.error({
              title: "Error",
              message: "Invalid input",
              showMethod: "slideInRight",
            });
          } else if (resp.data.result == 1) {
            this.$toast.error({
              title: "Error",
              message: "Incorrect pin or phone number",
              showMethod: "slideInRight",
            });
          } else {
            this.$toast.success({
              title: "Success",
              message: "Please check your lockers.",
              showMethod: "slideInRight",
            });
          }

          // alert(resp.data.message);
          // app.$router.push({ path: "/" });
        })
        .catch((resp) => {
          console.log(resp);
          // alert("Could not create your company");
          if (resp) {
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
