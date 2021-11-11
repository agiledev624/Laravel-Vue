
<template>
  <div class="text-left">
    <div class="form-group">
      <a @click="$router.go(-1)" class="btn btn-success">Back</a>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Edit Locker</div>
      <div class="panel-body">
        <form v-on:submit.prevent="saveForm()">
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
              <label class="control-label">Code</label>
              <input type="text" v-model="company.code" class="form-control" />
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Size</label>
              <input type="text" v-model="company.size" class="form-control" />
            </div>
          </div> -->
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Size</label>
              <div class="form-check">
                <input
                  value="0"
                  class="form-check-input"
                  type="radio"
                  name="flexRadioDefault"
                  id="flexRadioDefault1"
                  v-model="company.size"
                  :checked="company.size == 0"
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
                  value="1"
                  v-model="company.size"
                  :checked="company.size == 1"
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
                  value="2"
                  v-model="company.size"
                  :checked="company.size == 2"
                />
                <label class="form-check-label" for="flexRadioDefault3">
                  Large
                </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">COM Port</label>
              <input type="text" v-model="company.port" class="form-control" />
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
      .get("/api/v1/lockers/" + id)
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
        number: "",
        code: "",
        size: "",
        port: "",
      },
    };
  },
  methods: {
    saveForm() {
      var app = this;
      var newCompany = app.company;
      axios
        .patch("/api/v1/lockers/" + app.companyId, newCompany)
        .then(function (resp) {
          //app.$router.replace("/");
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
