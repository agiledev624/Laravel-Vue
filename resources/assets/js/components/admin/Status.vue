<template>
  <div>
    <!-- <div class="form-group text-left">
      <a @click="$router.go(-1)" class="btn btn-success">Back</a>
      <router-link
        :to="{ name: 'apartSetting' }"
        class="btn btn-default pull-right"
        >Create new Apartment</router-link
      >
    </div> -->

    <div class="panel panel-default">
      <div class="panel-heading text-left">Admin Status</div>
      <div class="panel-body text-left">
        <div>
          <strong>Total Users</strong>
          <span class="pull-right">{{ companies.total_users }}</span>
        </div>
        <div>
          <strong>Total Used Time</strong>
          <span class="pull-right">{{ companies.total_use }}</span>
        </div>
        <div>
          <strong>Total Registered Apartments</strong>
          <span class="pull-right">{{ companies.total_aparts }}</span>
        </div>
        <div>
          <strong>Total Registered Lockers</strong>
          <span class="pull-right">{{ companies.total_lockers }}</span>
        </div>
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
      companies: {
        total_use: "",
        total_users: "",
        total_lockers: "",
        total_aparts: "",
      },
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/v1/lockers/get_status/0")
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