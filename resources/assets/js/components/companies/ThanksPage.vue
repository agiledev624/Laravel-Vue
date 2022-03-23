
<template>
  <div>
    <div class="form-group text-left">
      <!-- <router-link to="/" class="btn btn-success">Home</router-link> -->
      <a @click="$router.go(-1)" class="btn btn-success pull-right">New</a>
      <!-- <router-link
        :to="{ name: 'apartList' }"
        class="btn btn-default pull-right"
        >Apartment List</router-link
      > -->
    </div>
    <img :src="'/img/thankyou.png'" class="thankyou" />
  </div>
</template>

<script>
import VueRecaptcha from "vue-recaptcha";
export default {
  components: { VueRecaptcha },
  data: function () {
    return {
      company: {
        size: "0",
        owner: "",
        recaptcha: "",
      },
      errors: [],
    };
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
      axios
        .post("/api/v1/lockers/new_assign", newCompany)
        .then((resp) => {
          console.log(resp);
          this.$refs.recaptcha.reset();
          if (resp.data.result == 0) {
            this.$toast.success({
              title: "Success",
              message: "Owner will get notified after lock.",
              showMethod: "slideInRight",
            });
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
          // alert("No available locker. Select another size.");
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
<style scoped>
@keyframes animetop {
  from {
    top: -300px;
    opacity: 0;
  }
  to {
    top: 0;
    opacity: 1;
  }
}
@keyframes grow {
  from {
    transform: scale(0);
  }
  to {
    transform: scale(1);
  }
}
.thankyou {
  width: 80%;
  animation: grow 0.5s;
}
</style>