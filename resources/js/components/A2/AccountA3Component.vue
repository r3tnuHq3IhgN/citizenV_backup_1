<template>
  <div>
<!-- Thông báo về khoảng thời gian khai báo còn lại  -->
    <div class="btn btn-danger" v-if="seC != 0 || miC != 0 || hC != 0">
      Còn <span v-if="dC != 0"> {{ dC }} ngày</span> {{ hC }} giờ {{ miC }} phút
      {{ seC }} giây để khai báo
    </div>
    <br />
    <br />
<!-- ----------------------------- -->

<!-- Kiểm tra tình trạng khai báo -->
    <div class="alert alert-danger" v-show="userActive == 'lock'">
      Thành phố đang bị khóa không thể khai báo cho các Quận/Huyện !
    </div>
    <div class="alert alert-success" v-show="userActive == 'active'">
      Thành phố được mở khai báo cho Quận/Huyện từ {{ allowOpen }} đến
      {{ allowClose }}
    </div>
    <!-- -------------------------------- -->
    <div v-show="userActive == 'active'" style="margin-top: 20px">
      <!-- Thống kê tài khoản cấp q/h -->
      <h1>Thống kê tài khoản cấp Quận/Huyện</h1>
      <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-striped mb-0">
          <thead>
            <tr>
              <th scope="col">Mã Quận</th>
              <th scope="col">Tên Quận</th>
              <th scope="col">Email</th>
              <th scope="col">Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(dis, index) in disAct" :key="index">
              <td>{{ dis.d_code }}</td>
              <td>{{ dis.district }}</td>
              <td>{{ dis.email }}</td>
              <td>
                <div
                  class="btn btn-primary"
                  @click="
                    open = null;
                    disNow = dis.district;
                    d_codeN = dis.d_code;
                    statusLock = false;
                    emptyRes = false;
                    cityActive = false;
                    success = null;
                    alrHave = null;
                    lockDis = 0; 
                    checkStatus();
                  "
                >
                  Mở khai báo
                </div>
                <div
                  class="btn btn-danger"
                  @click="
                    disNow = dis.district;
                    d_codeN = dis.d_code;
                    deleteTimeOpen();
                  "
                >
                  Khóa khai báo
                </div>
                <div
                  class="btn btn-info"
                  @click="
                    disNow = dis.district;
                    getStatus(dis.d_code);
                  "
                >
                  Trạng thái
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- ------------------------------- -->
      <br />

      <!-- Trạng thái khóa khai báo -->
      <div class="alert alert-warning" v-show="lockDis == 2">
        Khóa thành công thời hạn khai báo của Quận/Huyện{{ disNow }}
      </div>
      <div class="alert alert-warning" v-show="lockDis == 1">
        Quận/Huyện {{ disNow }} đang không khai báo !
      </div>
      <div class="alert alert-danger" v-show="alrHave == true">
        Quận/Huyện {{ disNow }} đang có thời điểm khai báo, khóa khai báo cũ
        trước khi cấp mới !
      </div>
      <div class="alert alert-success" role="alert" v-show="success == true">
        Mở thời hạn khai báo thành công cho tài khoản của Quận/Huyện
        {{ disNow }}
      </div>
      <!-- ---------------------------- -->

      <!-- Mở khai báo cho huyện -->
      <div v-show="open == true">
        <h3>Mở khai báo cho tài khoản của Quận/Huyện {{ disNow }}</h3>
        <div class="row">
          <label class="col-2">Thời điểm bắt đầu</label>
          <input
            type="datetime-local"
            v-model="dateOpen"
            :class="{ 'is-invalid': errors.open }"
            @click="
              invalidDate = null;
              errorOpen = null;
            "
          />
          <div class="invalid-feedback" style="margin-left: 110px">
            {{ errorOpen }}
          </div>
        </div>
        <br />
        <div class="row">
          <label class="col-2">Thời điểm kết thúc</label>
          <input
            type="datetime-local"
            v-model="dateClose"
            :class="{ 'is-invalid': errors.close }"
            @click="
              invalidDate = null;
              errorClose = null;
            "
          />
          <div class="invalid-feedback" style="margin-left: 110px">
            {{ errorClose }}
          </div>
        </div>
        <br />
        <div style="margin-left: 190px">
          <div class="btn btn-primary" @click="addTimeOpen()">Xác nhận</div>
          <div
            class="btn btn-danger"
            @click="
              open = false;
              errors = {};
              dateOpen = null;
              dateClose = null;
              invalidDate = null;
            "
          >
            Hủy
          </div>
        </div>
      </div>
      <!-- ------------------------ -->
      <br />

      <!-- Cảnh báo định dạng ngày lỗi -->
      <div class="alert alert-danger" v-show="invalidDate != null">
        {{ invalidDate }}{{ allowOpen }} đến {{ allowClose }}
      </div>
      <!-- -------------------------------- -->
    </div>
<!-- ---------------------------- -->

<!-- Kiểm tra trạng thái quận huyện -->
    <div v-if="emptyRes == true && open == false">
      <div class="alert alert-danger">
        Quận/Huyện {{ disNow }} đang khóa khai báo !
      </div>
    </div>
    <div v-if="statusLock == true && open == false">
      <div class="alert alert-danger">
        Quận/Huyện {{ disNow }} đang không trong thời gian khai báo (thời điểm
        hiện tại {{ this.timeN }})
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
        Quận/Huyện {{ disNow }} đang mở khai báo (thời điểm hiện tại
        {{ this.timeN }})
      </div>
      <div>Thời gian bắt đầu mở : {{ activeOpen }}</div>
      <div>Thời gian đóng khai báo : {{ activeClose }}</div>
      <br />
      <div class="btn btn-primary" @click="cityActive = false">
        Đóng thông báo
      </div>
    </div>
<!-- ----------------------------- -->
  </div>
</template> 

<script>
const axios = require("axios").default;
export default {
  props: {
    user: Object,
  },

  // watch seC để thay đổi cái clock
  watch: {
    seC: {
      handler(value) {
        if (value > 0) {
          setTimeout(() => { 
            this.seC--;
          }, 1000);
        } else if (
          value == 0 &&
          this.miC == 0 &&
          this.hC == 0 &&
          this.dC != 0
        ) {
          this.seC = 60;
          this.miC = 59;
          this.hC = 23;
          this.dC -= 1;
        } else if (value == 0 && this.miC == 0 && this.hC != 0) {
          this.seC = 60;
          this.miC = 59;
          this.hC -= 1;
        } else if (value == 0 && this.miC != 0) {
          this.seC = 60;
          this.miC -= 1;
        } else if (
          value == 0 &&
          this.miC == 0 &&
          this.hC == 0 &&
          this.dC == 0
        ) {
          this.userActive = "lock";
        }
      },
      immediate: true, // This ensures the watcher is triggered upon creation
    },
  },
  mounted() {
    this.userActive = this.user.active_status;

    // Lấy các huyện đã có cấp tài khoản
    axios
      .get("/api/getdisact/" + this.user.city_code)
      .then((response) => {
        this.disAct = response.data;
        //console.log(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
    var currentDateWithFormat = new Date();
    this.timeN = moment(currentDateWithFormat).format("YYYY-MM-DD HH:mm:ss");

    // Kiểm tra thời gian trong time_opens
    axios
      .get("/api/checktime/" + this.user.city_code)
      .then((response) => {
        if (response.data != "") {
          this.allowOpen = response.data[0].open;
          this.allowClose = response.data[0].close;

          // Nếu đang trong thời gian khai báo: sử lý time để hiện thị time còn lại
          if (this.allowOpen <= this.timeN && this.allowClose > this.timeN) {
            this.yC1 = parseInt(this.allowClose.slice(0, 4));
            this.moC1 = parseInt(this.allowClose.slice(5, 7));
            this.dC1 = parseInt(this.allowClose.slice(8, 10));
            this.yC2 = parseInt(this.timeN.slice(0, 4));
            this.moC2 = parseInt(this.timeN.slice(5, 7));
            this.dC2 = parseInt(this.timeN.slice(8, 10));

            class Date {
              constructor(d, m, y) {
                this.d = d;
                this.m = m;
                this.y = y;
              }
            }

            let monthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            function countLeapYears(d) {
              let years = d.y;

              // Check if the current year needs to be considered
              // for the count of leap years or not
              if (d.m <= 2) {
                years--;
              }

              // An year is a leap year if it is a multiple of 4,
              // multiple of 400 and not a multiple of 100.
              return (
                Math.floor(years / 4) -
                Math.floor(years / 100) +
                Math.floor(years / 400)
              );
            }

            // This function returns number
            // of days between two given dates
            function getDifference(dt1, dt2) {
              // COUNT TOTAL NUMBER OF DAYS BEFORE FIRST DATE 'dt1'

              // initialize count using years and day
              let n1 = dt1.y * 365 + dt1.d;

              // Add days for months in given date
              for (let i = 0; i < dt1.m - 1; i++) {
                n1 += monthDays[i];
              }

              // Since every leap year is of 366 days,
              // Add a day for every leap year
              n1 += countLeapYears(dt1);

              // SIMILARLY, COUNT TOTAL NUMBER OF DAYS BEFORE 'dt2'
              let n2 = dt2.y * 365 + dt2.d;
              for (let i = 0; i < dt2.m - 1; i++) {
                n2 += monthDays[i];
              }
              n2 += countLeapYears(dt2);

              // return difference between two counts
              return n2 - n1;
            }

            // Driver code
            this.date1 = new Date(this.dC1, this.moC1, this.yC1);
            this.date2 = new Date(this.dC2, this.moC2, this.yC2);
            this.dC = getDifference(this.date2, this.date1);

            this.yC = this.allowClose.slice(0, 4) - this.timeN.slice(0, 4);
            this.moC = this.allowClose.slice(5, 7) - this.timeN.slice(5, 7);
            //this.dC = this.allowClose.slice(8, 10) - this.timeN.slice(8, 10);
            this.hC = this.allowClose.slice(11, 13) - this.timeN.slice(11, 13);
            this.miC = this.allowClose.slice(14, 16) - this.timeN.slice(14, 16);
            this.seC = parseInt(
              this.allowClose.slice(17, 19) - this.timeN.slice(17, 19)
            );
            if (this.seC <= 0) {
              this.seC += 60;
              this.miC -= 1;
              if (this.miC < 0) {
                this.miC += 60;
                this.hC -= 1;
                if (this.hC < 0) {
                  this.hC += 24;
                  this.dC -= 1;
                }
              } else if (this.hC < 0) {
                this.hC += 24;
                this.dC -= 1;
              }
            }

            this.countDown = this.miC + this.hC * 60 + this.dC * 24 * 60;
          }
        }
      })
      .catch((error) => {
        console.log(error);
      });
  },
  data() {
    return {
      userActive: null,
      disAct: {},
      timeN: null,
      open: null,
      disNow: null,
      d_codeN: null,
      dateOpen: null,
      dateClose: null,
      allowOpen: null,
      allowClose: null,
      invalidDate: null,
      errors: {},
      errorOpen: null,
      errorClose: null,
      success: null,
      emptyRes: false,
      activeOpen: null,
      activeClose: null,
      statusLock: false,
      cityActive: false,
      alrHave: null,
      lockDis: 0,
      date1: null,
      date2: null,
      moC1: null,
      dC1: null,
      yC1: null,
      yC2: null,
      moC2: null,
      dC2: null,

      yC: 0,
      moC: 0,
      dC: 0,
      hC: 0,
      miC: 0,
      seC: 0,
    };
  },
  methods: {
    // kiểm tra trạng thái khai báo
    checkStatus() {
      axios
        .get("/api/checktime/" + this.d_codeN)
        .then((response) => {
          if (response.data != "") {
            this.alrHave = true;
          } else {
            this.open = true;
          }
        })
        .catch((error) => {});
    },

    // Thêm thời gian khai báo mới
    addTimeOpen() {
      axios
        .get("/api/user/" + this.user.id)
        .then((response) => {
          if (this.dateOpen != null && this.dateClose != null) {
            this.dateOpen = moment(this.dateOpen).format("YYYY-MM-DD HH:mm:ss");
            this.dateClose = moment(this.dateClose).format(
              "YYYY-MM-DD HH:mm:ss"
            );
            if (
              this.dateOpen >= this.allowOpen &&
              this.dateClose <= this.allowClose
            ) {
              axios
                .post("api/timeopen/", {
                  code: this.d_codeN,
                  open: this.dateOpen,
                  close: this.dateClose,
                })
                .then((response) => {
                  this.success = true;
                  this.open = false;
                  this.dateOpen = null;
                  this.dateClose = null;
                  this.invalidDate = null;
                  this.emptyRes = false;
                  this.cityActive = false;
                  this.statusLock = false;
                  this.alrHave = null;
                  this.lockDis = null;

                  var currentDateWithFormat = new Date();
                  this.timeN = moment(currentDateWithFormat).format(
                    "YYYY-MM-DD HH:mm:ss"
                  );
                  axios
                    .get("/api/checktime/" + this.d_codeN)
                    .then((response) => {
                      if (
                        response.data[0].open <= this.timeN &&
                        response.data[0].close >= this.timeN
                      ) {
                        axios
                          .get("/api/updateactive/" + this.d_codeN)
                          .then((response) => {
                            console.log(response);
                          })
                          .catch((error) => {
                            console.log(error);
                          });
                      } else {
                        axios
                          .get("/api/updatelock/" + this.d_codeN)
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
              this.dateOpen = null;
              this.dateClose = null;
              this.invalidDate =
                "Ngày khai báo không được để trống và chỉ được nằm trong khoảng ";
            }
          } else {
            this.dateOpen = null;
            this.dateClose = null;
            this.invalidDate =
              "Ngày khai báo không được để trống và chỉ được nằm trong khoảng ";
          }
        })
        .catch((error) => {
          console.log(error.data);
        });
    },
    getStatus(d_code) {
      this.open = false;
      this.emptyRes = false;
      this.cityActive = false;
      this.statusLock = false;
      this.success = null;
      this.alrHave = null;
      this.lockDis = null;
      axios
        //kiem tra thoi gian co nam trong thoi diem dang khai bao k
        .get("/api/checktime/" + d_code)
        .then((response) => {
          var currentDateWithFormat = new Date();
          this.timeN = moment(currentDateWithFormat).format(
            "YYYY-MM-DD HH:mm:ss"
          );
          if (response.data == "") {
            this.emptyRes = true;
          } else if (
            // dang trong thoi gian khai bao: lay status
            response.data[0].open <= this.timeN &&
            response.data[0].close >= this.timeN
          ) {
            this.activeOpen = response.data[0].open;
            this.activeClose = response.data[0].close;
            this.cityActive = true;
          } else {
            // khong trong thoi gian khai bao
            this.activeOpen = response.data[0].open;
            this.activeClose = response.data[0].close;
            this.statusLock = true;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteTimeOpen() {
      axios
        // xoa thoi diem khai bao trong bang time_opens
        .delete("/api/deleteopen/" + this.d_codeN)
        .then((response) => {
          if (response.data == "no") {
            this.lockDis = 1;
          } else {
            this.lockDis = 2;
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
