<template>
  <div class="container">
    <div v-show="newacc == false">
      <h3>Lựa chọn tỉnh thành phố</h3>
      <select class="d-block mb-6" v-model="select">
        <option v-for="(city, index) in cities" :key="index">
          {{ city.city }}
        </option>
      </select>
      <br />
      <div
        class="btn btn-primary mt-6"
        @click="
          getInfoCity(select);
          search = true;
          success = false;
        "
      >
        Tìm kiếm
      </div>
    </div>
    <br />
    <table class="table table-bordered table-striped mb-0" v-show="search == true && success == false">
      <thead>
        <tr>
          <th scope="col">Thành Phố</th>
          <th scope="col">Code</th>
          <th scope="col">Tài khoản</th>
          <th scope="col">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ city.city }}</td>
          <td v-show="city.code == null">{{ nullCode }}</td>
          <td v-show="city.code != null">{{ city.code }}</td>
          <td v-show="city.email == null">{{ nullEmail }}</td>
          <td v-show="city.email != null">{{ city.email }}</td>
          <td >
            <button class="btn btn-danger" v-show="city.email != null">Sửa</button>
            <span
              class="btn btn-primary"
              v-show="city.email == null"
              @click="newAcc(city.code)"
              >Cấp mới</span
            >
          </td>
        </tr>
      </tbody>
    </table>
    <br />
    <div class="alert alert-success" role="alert" v-show="success == true">
      Tạo thành công tài khoản cho thành phố {{ city.city }}
    </div>
    <div v-show="newacc == true">
      <h3>Cấp mới tài khoản cho TP {{ city.city }}</h3>
      <div class="form-group">
        <label for="exampleInputName">Tên</label>
        <input
          type="text"
          class="form-control"
          id="exampleInputName"
          placeholder="Enter name"
          v-model="name"
          :class="{ 'is-invalid': errors.name }"
          @click="errors.name=null"
        />
        <div class="invalid-feedback">
          {{ errorName }}
        </div>
      </div>
      <div class="form-group">
        <div>Code</div>
        <select v-model="code_use" @change="onChange($event)">
          <option v-for="(code, index) in code_access" :key="index">
            {{ code.code }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Địa chỉ email</label>
        <input
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          placeholder="Enter email"
          v-model="email"
          disabled
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
          :class="{ 'is-invalid': errors.pass }"
          @click="errors.pass=null"
        />
        <div class="invalid-feedback">
          {{ errorPass }}
        </div>
      </div>
      <button
        type="submit"
        class="btn btn-primary"
        @click.prevent="submitForm(code_use)"
      >
        Tạo tài khoản
      </button>
      <button class="btn btn-primary" @click="newacc = false">Hủy</button>
    </div>
  </div>
</template> 
<script>
const axios = require("axios").default;
export default {
  mounted() {
    axios
      .get("/api/city")
      .then((response) => {
        this.cities = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  data() {
    return {
      cities: {},
      select: "Hà Nội",
      search: false,
      city: [],
      nullEmail: "Chưa có tài khoản",
      nullCode: "Chưa cấp code",
      edit: false,
      newacc: false,
      name: "",
      code: "",
      email: "",
      pass: "",
      success: false,
      code_access: '',
      code_use: '',
      errors: {},
      errorName: null,
      errorPass: null,
    };
  },
  methods: {
    getInfoCity(select) {
      axios
        .get("/api/city/" + select)
        .then((response) => {
          this.city = response.data[0];
          //console.log(response.data[0]);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    submitForm: function (code) {
      axios
        .post("/api/registerA2", {  
          name: this.name,
          email: this.email,
          pass: this.pass,
          role: "a2",
          city_code: code,
          city: this.city.city,  

        })
        .then((response) => {
          this.success = true;
          this.newacc = false;
          //console.log(response);
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          //console.log(this.errors); 
          //error pass
          if(this.errors['pass']!= undefined ){
          this.errorPass = this.errors['pass'][0];
          }
          else{
          this.errorPass = '';
          }
          // error name
          if(this.errors['name']!= undefined ){
          this.errorName = this.errors['name'][0];
          }
          else{
          this.errorName = '';
          }
        });
    },
    newAcc(code) {
      axios
        .get("/api/getcode", {
        })
        .then((response) => {
          this.code_access = response.data;
          this.code_use = this.code_access[0].code;
          this.email = this.code_use + '@gmail.com'; 
        })
        .catch((error) => {
          console.log(error);
        });
      this.newacc = true;
    },
    onChange(event){
      this.email = this.code_use + '@gmail.com';
    }
  },
};
</script>
<style scoped>
td,
th {
  vertical-align: inherit;
  text-align: center;
}
tr > th {
  text-align: center;
}
.my-custom-scrollbar {
position: relative;
height: 250px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
</style>