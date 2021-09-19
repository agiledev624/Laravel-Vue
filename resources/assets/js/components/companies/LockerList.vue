<template>
  <div>
    <div class="form-group">
      <router-link :to="{ name: 'createCompany' }" class="btn btn-success"
        >Create new Locker</router-link
      >
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Lockers list</div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>COM Port</th>
              <th>Number</th>
              <th>Code</th>
              <th>Size</th>
              <th width="100">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(company, index) in companies">
              <td>{{ company.port }}</td>
              <td>{{ company.number }}</td>
              <td>{{ company.code }}</td>
              <td>{{ type(company.size) }}</td>
              <td>
                <div class="row">
                  <router-link
                    :to="{ name: 'editCompany', params: { id: company.id } }"
                    class="btn btn-xs btn-default"
                  >
                    Edit
                  </router-link>
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
      .get("/api/v1/lockers")
      .then(function (resp) {
        app.companies = resp.data;
      })
      .catch(function (resp) {
        console.log(resp);
        alert("Could not load companies");
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
          .delete("/api/v1/companies/" + id)
          .then(function (resp) {
            app.companies.splice(index, 1);
          })
          .catch(function (resp) {
            alert("Could not delete company");
          });
      }
    },
  },
};
</script>
