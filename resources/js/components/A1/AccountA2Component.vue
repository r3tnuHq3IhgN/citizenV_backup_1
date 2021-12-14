<template>
  <div>

    <!-- hiển thị tài khoản -->
    <h1>Thống kê tài khoản cấp Thành Phố</h1>
    <div class="table-wrapper-scroll-y my-custom-scrollbar">
      <table class="table table-bordered table-striped mb-0">
        <thead>
          <tr>
            <th scope="col">TP</th>
            <th scope="col">Tên</th>
            <th scope="col">Email</th>
            <th scope="col">Vai trò</th>
            <th scope="col">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="index">
            <td>{{ user.city }}</td> 
            <th scope="row">{{ user.name }}</th>
            <td>{{ user.email }}</td>
            <td>{{ user.role }}</td>
            <td>
              <button
                class="btn btn-primary"
                @click="
                  valueCity = user.city;
                  valueCode = user.city_code;
                  statusLock = false;
                  emptyRes = false;
                  cityActive = false;
                  lockCity = 0;
                  success = null;
                  city_codeN = user.city_code;
                  alrHave = null;
                  open = null;
                  checkStatus();
                "
              >
                Mở khai báo
              </button>
              <div
                class="btn btn-danger"
                @click="
                  deleteTimeOpen(user.city_code);
                  valueCity = user.city;
                "
              >
                Khóa khai báo
              </div>
              <div
                class="btn btn-info"
                @click="
                  getStatus(user.city_code);
                  valueCity = user.city;
                "
              >
                Trạng thái
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- ------------------ -->
    <br />

    <!-- Thông báo về khai báo thành công hay chưa -->
    <div class="alert alert-success" role="alert" v-show="success == true">
      Mở thời hạn khai báo thành công cho tài khoản của thành phố
      {{ valueCity }}
    </div>
    <div class="alert alert-warning" v-show="lockCity == 2">
      Khóa thành công thời hạn khai báo của thành phố {{ valueCity }}
    </div>
    <div class="alert alert-warning" v-show="lockCity == 1">
      Thành phố {{ valueCity }} đang không khai báo !
    </div>
    <div class="alert alert-danger" v-show="alrHave == true">
      Thành phố {{ valueCity }} đang có thời điểm khai báo, khóa khai báo cũ
      trước khi cấp mới !
    </div>
    <!-- ----------------------- -->

    <!-- Form mở thời gian khai báo -->
    <div v-show="open == true">
      <h3>Mở khai báo cho tài khoản của thành phố {{ valueCity }}</h3>
      <div class="form-group">
        <label class="col-2">Thời điểm bắt đầu</label>
        <input
          type="datetime-local"
          v-model="dateOpen"
          :class="{ 'is-invalid': errors.open }"
          @click="errorOpen = null"
        />
        <div class="invalid-feedback" style="margin-left: 190px">
          {{ errorOpen }}
        </div>
      </div>
      <br />
      <div class="form-group">
        <label class="col-2">Thời điểm kết thúc</label>
        <input
          type="datetime-local"
          v-model="dateClose"
          :class="{ 'is-invalid': errors.close }"
          @click="errorClose = null"
        />
        <div class="invalid-feedback" style="margin-left: 190px">
          {{ errorClose }}
        </div>
      </div>
      <br />
      <div style="margin-left: 190px">
        <div class="btn btn-primary" @click="addTimeOpen()">Xác nhận</div>
        <div
          class="btn btn-primary"
          @click="
            open = false;
            statusLock = false;
            errors = {};
            dateOpen = null;
            dateClose = null;
          "
        >
          Hủy
        </div>
      </div>
    </div>
    <!-- --------------------------- -->

    <!-- Thông báo về trạng thái khai báo -->
    <div v-if="emptyRes == true && open == false">
      <div class="alert alert-danger">
        Thành Phố {{ valueCity }} đang khóa khai báo !
      </div>
    </div>
    <div v-if="statusLock == true && open == false">
      <div class="alert alert-danger">
        Thành Phố {{ valueCity }} đang không trong thời gian khai báo (thời điểm
        hiện tại {{ this.time }})
      </div>
      <div>Thời gian bắt đầu mở : {{ activeOpen }}</div>
      <div>Thời gian đóng khai báo : {{ activeClose }}</div>
      <br />
      <div class="btn btn-primary" @click="statusLock = false">
        Đóng thông báo
      </div>
    </div>
    <div v-if="cityActive == true">
      <div class="alert alert-success">
        Thành phố {{ valueCity }} đang mở khai báo (thời điểm hiện tại
        {{ this.time }})
      </div>
      <div>Thời gian bắt đầu mở : {{ activeOpen }}</div>
      <div>Thời gian đóng khai báo : {{ activeClose }}</div>
      <br />
      <div class="btn btn-primary" @click="cityActive = false">
        Đóng thông báo
      </div>
    </div>
    <!-- ------------------------------ -->
  </div>
</template> 

<script>
import moment from "moment";
const axios = require("axios").default;
export default {
  mounted() {
    axios
      .get("/api/userA2")
      .then((response) => {
        this.users = response.data;
        //console.log(response);
      })
      .catch((error) => {
        // console.log(error);
      });
    // var currentDateWithFormat = new Date();
    // this.time = moment(currentDateWithFormat).format('YYYY-MM-DD HH:mm:ss');
    // console.log(this.time);
  },
  data() {
    return {
      users: {},
      edit: false,
      tg: null,
      open: false,
      valueCity: "",
      valueCode: "",
      dateOpen: null,
      dateClose: null,
      success: false,
      time: null,
      activeOpen: "",
      activeClose: "",
      messClose: "",
      statusLock: false,
      emptyRes: false,
      cityActive: false,
      lockCity: 0,
      test_date: "",
      city_codeN: null,
      errors: {},
      errorOpen: null,
      errorClose: null,
      alrHave: null,
    };
  },
  methods: {

    // Kiểm tra xem đã có ngày khai bao chưa
    checkStatus() {
      axios
        .get("/api/checktime/" + this.city_codeN)
        .then((response) => {
          if (response.data != "") {
            this.alrHave = true;
          } else {
            this.open = true;
          }
        })
        .catch((error) => {});
    },

    // Thêm khoảng thời gian vào bảng TimeOpen
    addTimeOpen() {
      if (this.dateOpen != null && this.dateClose != null) {
        axios
          .post("/api/timeopen", {
            code: this.valueCode,
            open: moment(this.dateOpen).format("YYYY-MM-DD HH:mm:ss"),
            close: moment(this.dateClose).format("YYYY-MM-DD HH:mm:ss"),
          })
          .then((response) => {
            this.lockCity = 0;
            this.success = true;
            this.open = false;
            this.dateOpen = "";
            this.dateClose = "";
            var currentDateWithFormat = new Date();
            this.time = moment(currentDateWithFormat).format(
              "YYYY-MM-DD HH:mm:ss" 
            );
            //console.log(response);
            axios
              .get("/api/checktime/" + this.city_codeN)
              .then((response) => {
                if (
                  response.data[0].open <= this.time &&
                  response.data[0].close >= this.time
                ) {
                  axios
                    .get("/api/updateactive/" + this.city_codeN)
                    .then((response) => {
                      //console.log(response);
                    })
                    .catch((error) => {
                      console.log(error); 
                    });
                } else {
                  axios
                    .get("/api/updatelock/" + this.city_codeN)
                    .then((response) => {
                      console.log(response);
                    })
                    .catch((error) => {
                      console.log(error);
                    });
                }
              })
              .catch((error) => {
                console.log();
              });
          })
          .catch((error) => {
            this.errors = error.response.data.errors;
            if (this.errors.open != null) {
              this.errorOpen = this.errors["open"][0];
            }
            if (this.errors.close != null) {
              this.errorClose = this.errors["close"][0];
            }
          });
      } else {
        axios
          .post("/api/timeopen", {
            code: this.valueCode,
            open: this.dateOpen,
            close: this.dateClose,
          })
          .then((response) => {})
          .catch((error) => {
            this.errors = error.response.data.errors;
            if (this.errors.open != null) {
              this.errorOpen = this.errors["open"][0];
            }
            if (this.errors.close != null) {
              this.errorClose = this.errors["close"][0];
            }
          });
      }
    },

    // Lấy trạng thái của TP xem có đang khai báo không
    getStatus(city_code) {
      this.emptyRes = false;
      this.cityActive = false;
      this.statusLock = false;
      this.success = false;
      this.open = false;
      this.lockCity = 0;
      this.alrHave = null;

      axios

        //Kiểm tra xem khoảng thời gian có nằm trong thời gian khai báo hay không
        .get("/api/checktime/" + city_code)
        .then((response) => {
          var currentDateWithFormat = new Date();
          this.time = moment(currentDateWithFormat).format(
            "YYYY-MM-DD HH:mm:ss"
          );
          if (response.data == "") {
            this.emptyRes = true;
          } else if (

            // Nằm trong khai báo: lấy status
            response.data[0].open <= this.time &&
            response.data[0].close >= this.time
          ) {
            this.activeOpen = response.data[0].open;
            this.activeClose = response.data[0].close;
            this.cityActive = true;
          } else {
            // Không nằm trong khoảng thời gian khai báo
            this.activeOpen = response.data[0].open;
            this.activeClose = response.data[0].close;
            this.statusLock = true;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // Xóa khoảng thời gian khai báo trong time_opens
    deleteTimeOpen(code) {
      axios
        .delete("/api/deleteopen/" + code)
        .then((response) => {
          // Chưa từng khai báo thì thông báo
          if (response.data == "no") {
            this.lockCity = 1;
          } else {
            this.lockCity = 2;
          }
          this.emptyRes = false;
          this.cityActive = false;
          this.statusLock = false;
          this.success = false;
          this.open = false;
          this.alrHave = null;
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
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
