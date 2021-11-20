<template>
  <div>
    <div class="form-group text-left">
      <a @click="$router.go(-1)" class="btn btn-success">Back</a>
      <router-link
        :to="{ name: 'apartSetting' }"
        class="btn btn-default pull-right"
        >Create new Apartment</router-link
      >
    </div>

    <div class="panel panel-default">
      <div class="panel-heading text-left">Users list</div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>User ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Port</th>
              <th>Role</th>
              <th>QR</th>
              <th>Allow</th>
              <th width="100">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(company, index) in companies">
              <td data-label="No">{{ index + 1 }}</td>
              <td data-label="User ID">{{ company.id }}</td>
              <td data-label="Name">{{ company.name }}</td>
              <td data-label="Address">{{ company.address }}</td>
              <td data-label="Phone">{{ company.phone }}</td>
              <td data-label="Port">{{ company.port }}</td>
              <td data-label="Role">{{ company.role }}</td>
              <td data-label="QR">
                <a :href="'/qrcode/' + company.id"
                  ><img style="width: 15px" :src="'/img/goto.svg'" alt=" Go"
                /></a>
              </td>
              <td data-label="Allow">
                <toggle-button
                  :value="true"
                  :labels="{ checked: 'On', unchecked: 'Off' }"
                />
              </td>
              <td data-label="Actions">
                <div class="row" style="margin-right: 0">
                  <router-link
                    :to="{ name: 'editApartment', params: { id: company.id } }"
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
import { ToggleButton } from "vue-js-toggle-button";
export default {
  components: { ToggleButton },
  data: function () {
    return {
      companies: [],
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/v1/users")
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
          .delete("/api/v1/users/" + id)
          .then(function (resp) {
            app.companies.splice(index, 1);
          })
          .catch(function (resp) {
            //alert("Could not delete company");
          });
      }
    },
  },
};
</script>
<style scoped>
table {
  border: 1px solid #ccc;
  width: 100%;
  margin: 0;
  padding: 0;
  border-collapse: collapse;
  border-spacing: 0;
}

table tr {
  border: 1px solid #ddd;
  padding: 5px;
  background: #fff;
}

table th,
table td {
  padding: 10px;
  text-align: center;
}

table th {
  text-transform: uppercase;
  letter-spacing: 1px;
}

@media screen and (max-width: 800px) {
  .panel-body table {
    border: 0;
  }

  .panel-body table thead {
    display: none;
  }

  .panel-body table tr {
    margin-bottom: 20px;
    display: block;
    border-bottom: 2px solid #ddd;
    box-shadow: 2px 2px 1px #dadada;
  }

  .panel-body table td {
    display: block;
    text-align: right;
    font-size: 13px;
  }

  .panel-body table td:last-child {
    border-bottom: 0;
  }

  .panel-body table td::before {
    content: attr(data-label);
    float: left;
    text-transform: uppercase;
    font-weight: bold;
  }
  .panel-body tbody {
    line-height: 0 !important;
  }
}
</style>