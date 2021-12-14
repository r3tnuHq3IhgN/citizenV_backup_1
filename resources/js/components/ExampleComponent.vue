<template>
  <div>
    <div
      class="btn btn-primary mb-3"
      @click="
        key = !key;
        success = false;
      "
      v-show="key == 0"
    >
      Tạo tài khoản cho A1
    </div>
    <div class="alert alert-success" role="alert" v-show="success == true">
      Tạo thành công tài khoản
    </div>
    <div v-show="key == 1">
      <div class="form-group">
        <label for="exampleInputName">Tên <span>(*)</span></label>
        <input
          class="form-control"
          id="exampleInputName"
          placeholder="Enter name"
          v-model="name"
          :class="{ 'is-invalid': errors.name }"
          @click="errors.name = null"
        />
        <div class="invalid-feedback">
          {{ errorName }}
        </div>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Địa chỉ email <span>(*)</span></label>
        <input
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          placeholder="Enter email"
          v-model="email"
          :class="{ 'is-invalid': errors.email }"
          @click="errors.email = null"
        />
        <div class="invalid-feedback">
          {{ errorEmail }}
        </div>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Mật khẩu <span>(*)</span></label>
        <input
          type="password"
          class="form-control"
          id="exampleInputPassword1"
          placeholder="Password"
          v-model="pass"
          :class="{ 'is-invalid': errors.pass }"
          @click="errors.pass = null"
        />
        <div class="invalid-feedback">
          {{ errorPass }}
        </div>
      </div>
      <div>
        <label>Chú ý:</label> <span>(*)</span> là các trường bắt buộc nhập
      </div>
      <div
        type="submit"
        class="btn btn-primary"
        @click.prevent="submitForm()"
      >
        Tạo tài khoản
      </div>
      <div class="btn btn-danger" @click="cancel()">Hủy</div>
    </div>
  </div>
</template>

<script>
const axios = require("axios").default;
export default {
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      key: 0,
      name: "",
      email: "",
      pass: "",
      success: false,
      errors: {},
      errorName: "",
      errorEmail: "",
      errorPass: "",
    };
  },
  methods: {
    submitForm() {
      axios
        .post("/api/register", {
          name: this.name,
          email: this.email,
          pass: this.pass,
          role: "a1",
        })
        .then((response) => {
          this.key = 0;
          this.success = true;
          this.name = "";
          this.email = "";
          this.pass = "";
          //this.errorsEmail = '';
          // console.log(response);
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          //console.log(this.errors);
          //error pass
          if (this.errors["pass"] != undefined) {
            this.errorPass = this.errors["pass"][0];
          } else {
            this.errorPass = "";
          }
          // error name
          if (this.errors["name"] != undefined) {
            this.errorName = this.errors["name"][0];
          } else {
            this.errorName = "";
          }
          //error email
          if (this.errors["email"] != undefined) {
            this.errorEmail = this.errors["email"][0];
          } else {
            this.errorEmail = "";
          }
          //console.log(this.errors['pass'])
          // console.log(this.errors['email'][0])
        });
    },
    cancel() {
      this.key = 0;
      this.name = "";
      this.email = "";
      this.pass = "";
      this.errors = {};
      this.errorName = "";
      this.errorEmail = "";
      this.errorPass = "";
    },
  },
  watch: {
    name: function (val) {
      this.$root.bladeName = val;
    },
  },
};
</script>
<style scoped>
label{
  font-weight: bold;
}
span{
  color: red;
}
</style>
