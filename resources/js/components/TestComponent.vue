<template>
  <div>
    <h1>Đây là trang ADMIN</h1>
    <div class="btn btn-primary mb-3" @click="key = !key" v-show="key == 0">
      Tạo tài khoản cho A1
    </div>
    <div v-show="key==1">
      <div class="form-group">
        <label for="exampleInputName">Tên</label>
        <input
          type="text"
          class="form-control"
          id="exampleInputName"
          placeholder="Enter name"
          v-model="name"
        />
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Địa chỉ email</label>
        <input
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          placeholder="Enter email"
          v-model="email"
        />
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Mật khẩu</label>
        <input
          type="password"
          class="form-control"
          id="exampleInputPassword1"
          placeholder="Password"
          v-model="pass"
        />
      </div>
      <button type="submit" class="btn btn-primary" @click.prevent="submitForm()">
        Tạo tài khoản
      </button>
    </div>
  </div>
</template>

<script>
const axios = require('axios').default;
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
    };
  },
  methods: { 
    submitForm: function () { 
      axios
        .post("/api/register", {
          name: this.name,
          email: this.email,
          pass: this.pass,
        })
        .then(function (response) {
          console.log(response);
        })
        .catch(function (error) {
          console.log(error); 
        });
    },
  },
  watch: {
    name: function (val) {
      this.$root.bladeName = val;
    },
  },
};
</script>
