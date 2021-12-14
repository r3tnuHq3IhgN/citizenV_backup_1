<template>
  <div>
    <div>
      <h3>Danh sách các Quận/Huyện đã tạo</h3>
      <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-striped mb-0">
          <thead>
            <tr>
              <th scope="col">Tên TP</th>
              <th scope="col">Mã Tỉnh/TP</th>
              <th scope="col">Tên Quận/Huyện</th>
              <th scope="col">Hoạt động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(dis, index) in all_dis" :key="index">
              <td>{{ dis.city }}</td>
              <td v-show="dis.c_code != null">{{ dis.c_code }}</td>
              <td v-show="dis.c_code == null">chưa có code</td>
              <td>{{ dis.district }}</td>
              <td>
                <div
                  class="btn btn-danger"
                  @click="deleteDistrict(dis.district,dis.city)"
                >
                  Xóa
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <br />
    <div
      class="btn btn-primary"
      style="margin-bottom: 10px"
      @click="
        create = true;
        success = null;
      "
      v-show="create == false"
    >
      Tạo Quận/Huyện mới
    </div>
    <div class="alert alert-success" v-show="success == true">
      Tạo mới thành công
    </div>
    <!-- <div class="alert alert-danger" v-show="success == false">
      Tỉnh thành đã được tạo từ trước
    </div> -->

    <div class="form-group" v-show="create == true">
      <h3>Tạo mới Quận/Huyện</h3>
      <label>Quận/Huyện thuộc về TP</label>
      <select class="d-block mb-6" v-model="select">
        <option v-for="(city, index) in cities" :key="index">
          {{ city.city }}
        </option>
      </select>
      <br />
      <label for="exampleInputName">Tên Quận/Huyện</label>
      <input
        type="text"
        class="form-control"
        id="exampleInputName"
        placeholder="Enter name"
        v-model="district"
        :class="{ 'is-invalid': error }"
        @click="error = null"
      />
      <div class="invalid-feedback">
        {{ error }}
      </div>
      <br />
      <div type="submit" class="btn btn-primary" @click="createDistrict">
        Tạo
      </div>
      <div type="submit" class="btn btn-danger" @click="create = false">
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
      .get("/api/city")
      .then((response) => {
        this.cities = response.data;
        this.select = this.cities[0].city;
      })
      .catch((error) => {
        console.log(error);
      });
    axios
      .get("/api/district")
      .then((response) => {
        this.all_dis = response.data;
        //console.log(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  data() {
    return {
      create: false,
      cities: {},
      select: "",
      district: null,
      success: null,
      all_dis: {},
      error: null,
    };
  },
  methods: {
    createDistrict() {
      axios
        .post("/api/createdistrict", {
          city: this.select,
          district: this.district,
        })
        .then((response) => {
          this.create = false;
          this.success = true;
          this.district = null;
          this.select = this.cities[0].city;
        })
        .catch((error) => {
          this.error = error.response.data.errors["district"][0];
        });
      axios
        .get("/api/district")
        .then((response) => {
          this.all_dis = response.data;
          //console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteDistrict(dis, city) { 
      if (confirm("Bạn chắc chắn muốn xóa Huyện này ?")) {
        axios
          .delete("/api/removedistrict/", {
            data: {
              dis: dis,
              city: city, 
            }, 
          })
          .then((response) => {
            console.log(response.data);
            axios
              .get("/api/district")
              .then((response) => {
                this.all_dis = response.data;
                //console.log(response.data);
              })
              .catch((error) => {
                console.log(error);
              });
            //console.log(response); 
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