<template>
  <div>
    <div class="form-group text-left">
      <a @click="$router.go(-1)" class="btn btn-success">Back</a>
      <router-link
        :to="{ name: 'courierSetting' }"
        class="btn btn-default pull-right"
        >Create new Courier</router-link
      >
    </div>

    <div class="panel panel-default">
      <div class="panel-heading text-left">Couriers list</div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Name</th>
              <th width="100">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(company, index) in companies" v-bind:key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ company.name }}</td>
              <td>
                <div class="row">
                  <!-- <router-link
                    :to="{ name: 'editCourier', params: { id: company.id } }"
                    class="btn btn-xs btn-default"
                  >
                    Edit
                  </router-link> -->
                  <a
                    href="#"
                    class="btn btn-xs btn-default"
                    v-on:click="resetPassword(company.id, index)"
                  >
                    Reset
                  </a>
                  <a
                    href="#"
                    class="btn btn-xs btn-danger"
                    v-on:click="deleteEntry(company.id, index)"
                  >
                    Delete
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      companies: [],
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/v1/couriers/list/" + this.$userId)
      .then(function (resp) {
        app.companies = resp.data;
      })
      .catch(function (resp) {
        console.log(resp);
        //alert("Could not load companies");
      });
  },
  methods: {
    type(id) {
      switch (id) {
        case "0":
          return "Small";
        case "1":
          return "Medium";
        case "2":
          return "Large";
      }
      return "Small";
    },
    deleteEntry(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/v1/couriers/" + id)
          .then(function (resp) {
            app.companies.splice(index, 1);
          })
          .catch(function (resp) {
            //alert("Could not delete company");
          });
      }
    },
    resetPassword(id) {
      if (confirm("Do you really want to reset password to 123456?")) {
        var app = this;
        // axios
        //   .post("/api/v1/couriers/reset_password", { id: id })
        //   .then(function (resp) {
        //     // app.companies.splice(index, 1);
        //     this.$toast.success({
        //       title: "Success",
        //       message: "Password Reset.",
        //       showMethod: "slideInRight",
        //     });
        //   })
        //   .catch(function (resp) {
        //     //alert("Could not delete company");
        //   });

        axios
          .put(`/api/v1/couriers/${id}`, { password: "123456" })
          .then(function (resp) {
            app.$toast.success({
              title: "Success",
              message: "Password Reset.",
              showMethod: "slideInRight",
            });
          })
          .catch(function (resp) {
            //alert("Could not delete company");
          });
      }
    },
  },
};
</script>
