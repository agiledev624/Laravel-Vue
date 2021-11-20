
<template>
  <div class="text-left">
    <div class="form-group">
      <a @click="$router.go(-1)" class="btn btn-success">Back</a>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Edit Apartment</div>
      <div class="panel-body">
        <form v-on:submit.prevent="saveForm()">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">No</label>
              <input type="text" v-model="company.id" class="form-control" />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Number</label>
              <input
                type="text"
                v-model="company.number"
                class="form-control"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Phone</label>
              <input type="text" v-model="company.phone" class="form-control" />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Pin</label>
              <input type="text" v-model="company.pin" class="form-control" />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <button class="btn btn-success">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    let app = this;
    let id = app.$route.params.id;
    app.companyId = id;
    axios
      .get("/api/v1/aparts/" + id)
      .then(function (resp) {
        app.company = resp.data;
      })
      .catch(function () {
        //alert("Could not load your company");
      });
  },
  data: function () {
    return {
      companyId: null,
      company: {
        id: "",
        number: "",
        phone: "",
        pin: "",
      },
    };
  },
  methods: {
    saveForm() {
      var app = this;
      var newCompany = app.company;
      axios
        .patch("/api/v1/aparts/" + app.companyId, newCompany)
        .then(function (resp) {
          // app.$router.replace("/");
          this.$toast.success({
            title: "Success",
            message: "Information Updated",
            showMethod: "slideInRight",
          });
          app.$router.go(-1);
        })
        .catch(function (resp) {
          console.log(resp);
          //alert("Could not create your company");
        });
    },
  },
};
</script>
