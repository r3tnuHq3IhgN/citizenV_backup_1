<template>
  <div>
    <h3>Danh sách các quận/huyện</h3>
    <div class="table-wrapper-scroll-y my-custom-scrollbar">
      <table class="table table-bordered table-striped mb-0">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Mã TP</th>
            <th scope="col">Tên Quận/Huyện</th>
            <th scope="col">Mã Quận</th>
            <th scope="col">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(dis, index) in disAll" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ dis.c_code }}</td>
            <th scope="row">{{ dis.district }}</th>
            <td v-show="dis.d_code != null">{{ dis.d_code }}</td>
            <td v-show="dis.d_code == null">Chưa có</td>
            <td v-show="dis.d_code == null">
              <button
                class="btn btn-primary"
                @click="
                  disNow = dis.district;
                  codeC = dis.c_code;
                  stt = index + 1;
                  success = false;
                  errorName = null;
                  errorPass = null;
                  newAcc();
                "
              >
                Tạo mã
              </button>
            </td>

            <td v-show="dis.d_code != null">
              <button class="btn btn-danger">Sửa</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <br />
    <div v-show="create == true">
      <h3>Cấp mới tài khoản cho Quận/Huyện {{ disNow }}</h3>
      <div class="form-group">
        <label for="exampleInputName">Tên</label>
        <input
          type="text"
          class="form-control"
          id="exampleInputName"
          placeholder="Enter name"
          v-model="name"
          :class="{ 'is-invalid': errors.name }"
          @click="errors.name = null"
        />
        <div v-show="errors.name==null"></div>
        <div class="invalid-feedback">
          {{ errorName }}
        </div> 
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
          @click="errors.pass = null"
        />
        <div v-show="errors.pass==null"></div>
        <div class="invalid-feedback">
          {{ errorPass }}
        </div>
      </div>
      <button
        type="submit"
        class="btn btn-primary"
        @click.prevent="createAcc()"
      >
        Tạo tài khoản
      </button>
      <button class="btn btn-danger" @click="create = false">Hủy</button>
    </div>
    <br>
    <div class="alert alert-success" role="alert" v-show="success == true">
      Tạo thành công tài khoản cho Quận/Huyện {{ disNow }}
    </div>
  </div>
</template>
<script>
const axios = require("axios").default;  
export default {
  props: {
    user: Object
  },
  mounted() {
    axios
      .get("/api/getdisof/" + this.user.id)
      .then((response) => {
        this.disAll = response.data;
        //console.log(response);
      })
      .catch((error) => {
        console.log(error);
      });
    //console.log(this.userid);
  },
  data() {
    return {
      disAll: {},
      create: null,
      disNow: null,
      codeC: null,
      d_code: null,
      stt: null,
      name: "",
      pass: "",
      email: "",
      errors: {},
      errorName: null,
      errorPass: null,
      success: null,
    };
  },
  methods: {
    newAcc() {
      this.create = true;
      if (this.stt < 10) {
        this.stt = "0" + this.stt;
      }
      this.d_code = this.codeC + this.stt;
      this.email = this.codeC + this.stt + "@gmail.com";
    },
    createAcc() {
      axios
        .post("/api/registerA3", { 
          name: this.name,
          email: this.email,
          pass: this.pass,
          city_code: this.d_code, 
          role: "a3",
          d_code: this.d_code,
          dis: this.disNow,
        })
        .then((response) => {
          this.create = false;
          this.success = true;
          axios
            .get("/api/getdisof/" + this.user.id)
            .then((response) => {
              this.disAll = response.data;
              //console.log(response);
            })
            .catch((error) => {
              console.log(error);
            });
          //console.log(response);
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
        });
    },
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