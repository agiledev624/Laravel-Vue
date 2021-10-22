
<template>
  <div>
    <div class="form-group">
      <router-link
        :to="{ name: 'courierPage' }"
        class="btn btn-warning text-large"
        >Courier</router-link
      >
      <router-link
        :to="{ name: 'ownerPage' }"
        class="btn btn-success text-large"
        >Owner</router-link
      >
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    // let app = this;
    // let id = app.$route.params.id;
    // app.companyId = id;
    // axios
    //   .get("/api/v1/companies/" + id)
    //   .then(function (resp) {
    //     app.company = resp.data;
    //   })
    //   .catch(function () {
    //     alert("Could not load your company");
    //   });
  },
  data: function () {
    return {
      companyId: null,
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
        .patch("/api/v1/companies/" + app.companyId, newCompany)
        .then(function (resp) {
          app.$router.replace("/");
        })
        .catch(function (resp) {
          console.log(resp);
          alert("Could not create your company");
        });
    },
  },
};
</script>
<style scoped>
.link {
  font-weight: 300;
  font-size: large;
  height: 20%;
  width: 20%;
  border: solid 1px grey;
  border-radius: 10px;
  margin: 20px;
  padding: 20px;
  color: black !important;
}
.text-large {
  font-size: 20px;
}
</style>