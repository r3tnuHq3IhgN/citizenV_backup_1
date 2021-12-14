<template>
  <div>
    <div>
      <h3>Danh sách các Tỉnh Thành đã tạo</h3>
      <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-striped mb-0">
          <thead>
            <tr>
              <th scope="col">STT</th>
              <th scope="col">Thành Phố</th>
              <th scope="col">Hoạt động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(city, index) in cities" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ city.city }}</td>
              <td>
                <div
                  class="btn btn-danger"
                  @click="
                    deleteCity(city.city);
                    success = null;
                  "
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
        create = !create;
        success = null;
      "
      v-show="create == false"
    >
      Tạo thành phố mới
    </div>
    <div class="alert alert-success" v-show="success == true">
      Tạo mới thành công
    </div>
    <div class="form-group" v-show="create == true">
      <label for="exampleInputName">Tên tỉnh/thành phố</label>
      <input
        type="text"
        class="form-control"
        id="exampleInputName"
        placeholder="Enter name"
        v-model="city_name"
        :class="{ 'is-invalid': error }"
        @click="error = null"
      />
      <div class="invalid-feedback">
        {{ error }}
      </div>
      <br />
      <div type="submit" class="btn btn-primary" @click="addNewCity()">Tạo</div>
      <div
        type="submit"
        class="btn btn-danger"
        @click="
          create = false;
          error = null;
        "
      >
        Hủy
      </div>
    </div>
  </div>
</template>
<script>
const axios = require("axios").default;
export default {
  mounted() {
    axios
      .get("api/city")
      .then((response) => {
        this.cities = response.data;
        //console.log(this.cities);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  data() {
    return {
      create: false,
      cities: {},
      city_name: null,
      success: null,
      error: null,
    };
  },
  methods: {
    addNewCity() {
      axios
        .post("api/createcity", {
          city: this.city_name,
        })
        .then((response) => {
          this.success = true;
          setTimeout(() => (this.success = false), 2000);
          this.create = false;
          this.city_name = ""; 
          axios
            .get("api/city")
            .then((response) => {
              this.cities = response.data;
              //console.log(this.cities);
            })
            .catch((error) => {
              console.log(error);
            });
          //console.log(response);
        })
        .catch((error) => {
          this.error = error.response.data.errors["city"][0];
          //console.log(this.error);
        });
    },
    deleteCity(city) {
      if (confirm("Bạn chắc chắn muốn xóa TP này ?")) {
        axios
          .delete("/api/removecity/" + city)
          .then((response) => {
            axios
              .get("api/city")
              .then((response) => {
                this.cities = response.data;
                //console.log(this.cities);
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