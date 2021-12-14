<template>
  <div>
    <div>
      <h3>Danh sách các Xã/Phường đã tạo</h3>
      <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-striped mb-0">
          <thead>
            <tr>
              <th scope="col">Tên TP</th>
              <th scope="col">Tên Quận</th>
              <th scope="col">Tên Xã</th>
              <th scope="col">Hoạt động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(com, index) in all_com" :key="index">
              <td>{{ com.city }}</td>
              <td>{{ com.district }}</td>
              <td>{{ com.commune }}</td>
              <td>
                <div
                  class="btn btn-danger"
                  @click="deleteCommune(com.district, com.commune)"
                >
                  Xóa
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div
      class="btn btn-primary"
      style="margin-bottom: 10px; margin-top: 10px"
      @click="
        create1 = true;
        success = null;
        open = false;
      "
      v-show="open == true"
    >
      Tạo Xã/Phường mới
    </div>
    <br>
    <div class="alert alert-success" v-show="success == true">
      Tạo mới thành công
    </div>

    <div class="form-group" v-show="create1 == true">
      <br>
      <h3>Chọn Thành Phố</h3>
      <select class="d-block mb-6" v-model="select1">
        <option v-for="(city, index) in cities" :key="index">
            {{city.city}}
        </option>
      </select>
      <div class="btn btn-primary" style="margin-top: 10px" @click="create=true;create1=false;selectCity()">Chọn</div>
      <div class="btn btn-danger" style="margin-top: 10px" @click="create1=false;open=true">Hủy</div>
    </div>
    <div class="form-group" v-show="create == true">
      <h3>Đang thêm xã phường nằm trong TP {{select1}}</h3>
      <label>Xã/Phường thuộc về Quận/Huyện</label>
      <select class="d-block mb-6" v-model="select">
        <option v-for="(dis, index) in disOfCity" :key="index">
          {{ dis.district }}
        </option>
      </select>
      <br />
      <label for="exampleInputName">Tên Xã/Phường</label>
      <input
        type="text"
        class="form-control"
        id="exampleInputName"
        placeholder="Enter name"
        v-model="commune"
        :class="{ 'is-invalid': error }"
        @click="error = null"
      />
      <div class="invalid-feedback">
        {{ error }}
      </div>
      <br />
      <div type="submit" class="btn btn-primary" @click="createCommune()">
        Tạo
      </div>
      <div
        type="submit"
        class="btn btn-danger"
        @click="
          create = false;
          create1 = true;
          error = null;
          commune = null;
        "
      >
        Hủy
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  mounted() {
    axios
      .get("api/city")
      .then((response) => {
        this.cities = response.data;
        this.select1 = this.cities['0'].city;
        //console.log(this.cities);
      })
      .catch((error) => {
        console.log(error);
      });
    axios
      .get("/api/communes")
      .then((response) => {
        this.all_com = response.data;
        //console.log(response);
      })
      .catch((error) => {
        console.log(error);   
      });
  },
  data() {
    return {
      open: true,
      create1: false,
      create: false,
      select: null,
      select1: null,
      disOfCity: {},
      d_codeN: null,
      commune: null,
      error: null,
      success: null,
      all_com: {},
      cities: {},
    };
  },
  methods: {
    selectCity(){  
        axios
      .get("/api/disofcity/"+this.select1)
      .then((response) => {
        this.disOfCity = response.data;
        this.select = this.disOfCity[0].district;
        //console.log(response);
      })
      .catch((error) => {
        console.log(error); 
      });
    },
    createCommune() {
      axios 
      .get('/api/getcodeofdis/'+this.select)
      .then((response) => {
        this.d_codeN = response.data['0'].d_code;
        axios
        .post("/api/createcommune", {
          district: this.select,
          d_code: this.d_codeN,
          commune: this.commune,  
        })
        .then((response) => {
          if (response.data != "no") {
            this.create = false;
            this.create1 = false;
            this.open = true;
            this.success = true;
            this.commune = null;
            this.select = this.disOfCity[0].district; 
            this.error = null;
            axios
              .get("/api/communes")
              .then((response) => {
                this.all_com = response.data;
                //console.log(response);
              })
              .catch((error) => {
                console.log(error);
              });
          } else {
            this.error = "Xã đã được tạo trước đó, hãy kiểm tra  lại !";
          }
        })
        .catch((error) => {
          this.error = error.response.data.errors["commune"][0];
          //console.log(error.response.data);
        });
      })
      .catch((error) => {
        console.log(error);
      });
    },
     
    //nen doi d_code
    deleteCommune(d_code, comm) {
      if (confirm("Bạn chắc chắn muốn xóa Xã này ?")) {
        axios
          .delete("/api/deletecom", {
            data: {
              d_code: d_code,
              commune: comm,  
            },
          })
          .then((response) => {
            this.success = null;
            axios
              .get("/api/communes")
              .then((response) => {
                this.all_com = response.data;
                //console.log(response);
              })
              .catch((error) => {
                console.log(error);
              });
          })
          .catch((error) => {
            console.log(error);
          });
      }
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