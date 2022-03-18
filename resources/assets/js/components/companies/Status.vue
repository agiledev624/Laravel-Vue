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
      <div class="panel-heading text-left">Manager Status</div>
      <div class="panel-body text-left">
        <div>
          <strong>Total Aparts</strong>
          <span class="pull-right">{{ companies.total_aparts }}</span>
        </div>
        <div>
          <strong>Total Lockers</strong>
          <span class="pull-right">{{ companies.total_lockers }}</span>
        </div>
        <div>
          <strong>Available Lockers</strong>
          <span class="pull-right">{{
            companies.total_lockers - companies.unopened
          }}</span>
        </div>
        <div>
          <strong>Filled Lockers</strong>
          <span class="pull-right">{{ companies.unopened }}</span>
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading text-left">Filled Lockers</div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Id</th>
              <th>Owner</th>
              <th>Locked Time</th>
              <th width="100">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(company, index) in lockers.filter((i) => i.owner != '0')"
              v-bind:key="index"
              v-bind:class="{
                'expire-background': isTooExpired(company.locked_time),
              }"
            >
              <td>{{ index + 1 }}</td>
              <td>{{ company.number }}</td>
              <td>{{ company.owner }}</td>
              <td>{{ diff(company.locked_time) }}</td>
              <td>
                <div class="row">
                  <a
                    class="btn btn-xs btn-default"
                    href="#"
                    v-on:click="notifyOwner(company.owner)"
                  >
                    Notify
                  </a>
                  <a
                    href="#"
                    class="btn btn-xs btn-danger"
                    v-on:click="openLocker(company.owner, company.number)"
                  >
                    Open
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
import moment from "moment";
export default {
  components: { ToggleButton },
  data: function () {
    return {
      companies: {
        unopened: "",
        total_lockers: "",
        total_aparts: "",
      },
      lockers: [],
      interval: null,
      min: 0,
    };
  },
  mounted() {
    if (!!this.interval) {
      clearInterval(this.interval);
    }

    this.interval = setInterval(this.increaseMin, 1000);

    var app = this;
    axios
      .get(`/api/v1/lockers/get_status/${this.$userId}`)
      .then(function (resp) {
        app.companies = resp.data;
      })
      .catch(function (resp) {
        console.log(resp);
        //alert("Could not load companies");
      });

    axios
      .get("/api/v1/lockers/list/" + this.$userPort)
      .then(function (resp) {
        console.log(resp.data);
        app.lockers = resp.data;
      })
      .catch(function (resp) {
        console.log(resp);
        //alert("Could not load companies");
      });
  },
  methods: {
    increaseMin() {
      this.min = parseInt(this.min) + 1;
    },
    isTooExpired(then) {
      var ms = moment(new Date()).diff(moment.unix(then));
      var d = moment.duration(ms).add(this.min, "seconds");
      return Math.floor(d.asHours()) >= 48;
    },
    diff(then) {
      var ms = moment(new Date()).diff(moment.unix(then));
      var d = moment.duration(ms).add(this.min, "seconds");
      var s =
        Math.floor(d.asHours()) + "h " + moment.utc(ms).format("m[m] s[s]");
      return s;
    },
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
    openLocker(id) {
      if (confirm("Do you really want to open it?")) {
        var app = this;
        axios
          .post("/api/v1/lockers/open_locker", { id: id })
          .then(function (resp) {
            if (resp.data.result != 0) return;
            var app = this;
            axios
              .get(`/api/v1/lockers/get_status/${this.$userId}`)
              .then(function (resp) {
                app.companies = resp.data;
              })
              .catch(function (resp) {
                console.log(resp);
                //alert("Could not load companies");
              });

            this.$toast.success({
              title: "Success",
              message: "Opened the locker.",
              showMethod: "slideInRight",
            });

            axios
              .get("/api/v1/lockers/list/" + this.$userPort)
              .then(function (resp) {
                console.log(resp.data);
                app.lockers = resp.data;
              })
              .catch(function (resp) {
                console.log(resp);
                //alert("Could not load companies");
              });
          })
          .catch(function (resp) {
            //alert("Could not delete company");
          });
      }
    },
    notifyOwner(owner) {
      axios
        .post("/api/v1/lockers/notify_owner", {
          user_id: this.$userId,
          apart_number: owner,
        })
        .then(function (resp) {
          if (resp.data.result == 0) {
            this.$toast.success({
              title: "Success",
              message: "Sent sms to the owner.",
              showMethod: "slideInRight",
            });
          }
        })
        .catch(function (resp) {
          //alert("Could not delete company");
        });
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

.expire-background {
  background: lightpink !important;
}
</style>