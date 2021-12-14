<template>
  <div>
    <div>
      <h3>Danh sách các Thôn/Bản/Tổ dân phố đã tạo</h3>
      <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-striped mb-0">
          <thead>
            <tr>
              <th scope="col">Tên TP</th>
              <th scope="col">Tên Quận/Huyện</th>
              <th scope="col">Tên Xã/Phường</th>
              <th scope="col">Tên Thôn/Bản/Tổ dân phố</th>
              <th scope="col">Hoạt động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(ham, index) in all_ham" :key="index">
              <td>{{ ham.city }}</td>
              <td>{{ ham.district }}</td>
              <td>{{ ham.commune }}</td>
              <td>{{ ham.hamlet }}</td>
              <td>
                <div
                  class="btn btn-danger"
                  @click="deleteHamlet(ham.commune, ham.hamlet)"
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
        open = false;
      "
      v-show="open == true"
    >
      Tạo Thôn/Bản/Tổ dân phố mới
    </div>
    <br />
    <div class="alert alert-success" v-show="success == true">
      Tạo mới thành công
    </div>

    <div class="form-group" v-show="create == true">
      <br />
      <h3>Chọn Thành Phố</h3>
      <select class="d-block mb-6" v-model="select">
        <option v-for="(city, index) in cities" :key="index">
          {{ city.city }}
        </option>
      </select>
      <div
        class="btn btn-primary"
        style="margin-top: 10px"
        @click="
          create = false;
          create1 = true;
          selectCity();
        "
      >
        Chọn
      </div>
      <div
        class="btn btn-danger"
        style="margin-top: 10px"
        @click="
          create = false;
          open = true;
        "
      >
        Hủy
      </div>
    </div>

    <div class="form-group" v-show="create1 == true">
      <label>Chọn Quận/Huyện</label>
      <select class="d-block mb-6" v-model="select1">
        <option v-for="(dis, index) in disOfCity" :key="index">
          {{ dis.district }}
        </option>
      </select>
      <div
        class="btn btn-primary"
        style="margin-top: 10px"
        @click="
          create1 = false;
          create2 = true;
          selectDis();
        "
      >
        Chọn
      </div>
      <div
        class="btn btn-danger"
        style="margin-top: 10px"
        @click="
          create1 = false;
          create = true;
        "
      >
        Hủy
      </div>
    </div>

    <div class="form-group" v-show="create2 == true">
      <label>Chọn Xã/Phường</label>
      <select class="d-block mb-6" v-model="select2">
        <option v-for="(com, index) in comOfDis" :key="index">
          {{ com.commune }}
        </option>
      </select>
      <br />
      <label for="exampleInputName">Tên Thôn/Bản/Tổ dân phố</label>
      <input
        type="text"
        class="form-control"
        id="exampleInputName"
        placeholder="Enter name"
        v-model="hamlet"
        :class="{ 'is-invalid': error }"
        @click="error = null"
      />
      <div class="invalid-feedback">
        {{ error }}
      </div>
      <br />
      <div type="submit" class="btn btn-primary" @click="createHamlet()">
        Tạo
      </div>
      <div
        type="submit"
        class="btn btn-danger"
        @click="
          create2 = false;
          create1 = true;
          hamlet = null;
        "
      >
        Hủy
      </div>
    </div>
  </div>
</template> 
<script>
export default {
  mounted() {
    axios
      .get("api/city")
      .then((response) => {
        this.cities = response.data;
        this.select = this.cities["0"].city;
        //console.log(this.cities);
      })
      .catch((error) => {
        console.log(error);
      });
    axios
      .get("/api/hamlets")
      .then((response) => {
        this.all_ham = response.data;
        //console.log(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  },
  data() {
    return {
      open: true,
      create: false,
      create1: false,
      create2: false,
      select: null,
      select1: null,
      select2: null,
      hamlet: null,
      com_codeN: null,
      cities: {},
      all_ham: {},
      disOfCity: {},
      comOfDis: {},
      error: null,
      success: null,
    };
  },
  methods: {
    selectCity() {
      axios
        .get("/api/disofcity/" + this.select)
        .then((response) => {
          this.disOfCity = response.data;
          this.select1 = this.disOfCity[0].district;
          //console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    selectDis() {
      axios
        .get("/api/comofdis/" + this.select1)
        .then((response) => {
          this.comOfDis = response.data;
          this.select2 = this.comOfDis[0].commune;
          //console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    createHamlet() {
      axios
        .get("/api/getcodeofcom/" + this.select2)
        .then((response) => {
          this.com_codeN = response.data["0"].com_code;
          //console.log(this.com_codeN);

          axios
            .post("/api/createhamlet", {
              commune: this.select2,
              com_code: this.com_codeN,
              hamlet: this.hamlet,
            })
            .then((response) => {
              if (response.data != "no") {
                this.create = false;
                this.create1 = false;
                this.create2 = false;
                this.open = true;
                this.success = true;
                this.hamlet = null;
                this.error = null;
                axios
                  .get("/api/hamlets")
                  .then((response) => {
                    this.all_ham = response.data;
                    //console.log(response.data);
                  })
                  .catch((error) => {
                    console.log(error);
                  });
              } else {
                this.error =
                  "Thôn/Bản/Tổ dân phố đã được tạo trước đó, hãy kiểm tra  lại !";
              }
              //console.log(response);
            })
            .catch((error) => {
              this.error = error.response.data.errors["hamlet"][0];
              //console.log(error.response.data);
            });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteHamlet(com,ham){
        if (confirm("Bạn chắc chắn muốn xóa Thôn này ?")) {
        axios
          .delete("/api/deleteham", {
            data: {
              com: com,
              ham: ham, 
            },
          }) 
          .then((response) => {
            this.success = null;
            axios
              .get("/api/hamlets")
              .then((response) => {
                this.all_ham = response.data;
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