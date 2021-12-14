<template>
  <div>
    <!-- Thông báo về khoảng thời gian khai báo còn lại  -->
    <div class="btn btn-danger" v-if="seC != 0 || miC != 0 || hC != 0">
      Còn <span v-if="dC != 0" style="color: white"> {{ dC }} ngày</span>
      {{ hC }} giờ {{ miC }} phút {{ seC }} giây để nhập dữ liệu
    </div>
    <br />
    <br /> 
    <!-- ----------------------------------------------- -->
    <!-- Kiểm tra tình trạng khai báo -->
    <div class="btn btn-danger" v-show="userActive == 'lock'">
      Thôn/Bản/Tổ dân phố đang bị khóa không thể khai báo!
    </div>
    <div class="btn btn-success" v-show="userActive == 'active'">
      Thôn/Bản/Tổ dân phố được mở khai báo từ {{ allowOpen }} đến
      {{ allowClose }}
    </div>
    <br />
    <br />
    <transition name="fade">
      <div class="alert alert-success" v-show="success == true">
        Nhập thành công dữ liệu !
      </div>
    </transition>
    <!-- -------------------------------- -->
    <div v-show="userActive == 'active'" class="main">
      <div>
        <form>
          <br />
          <h3>Nhập dữ liệu điều tra dân số</h3>
          <div class="form-group">
            <label for="exampleInputEmail1"
              >Số CCCD/CMND (với người đã được cấp)</label
            >
            <input
              type="text"
              class="form-control"
              placeholder="Enter CMND"
              v-model="id_card"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"
              >Họ và tên <span>(*)</span></label
            >
            <input
              type="text"
              class="form-control"
              v-model="full_name"
              :class="{ 'is-invalid': errors.full_name }"
              @click="
                errorFull_name = null;
                errors.full_name = null;
              "
            />
            <div class="invalid-feedback">
              {{ errorFull_name }}
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"
              >Ngày tháng năm sinh <span>(*)</span></label
            >
            <input
              type="date"
              style="display: block"
              v-model="date_of_birth" 
              :class="{ 'is-invalid': errors.date_of_birth }"
              @click="
                errorDate_of_birth = null;
                errors.date_of_birth = null;
              "
            />
            <div class="invalid-feedback">
              {{ errorDate_of_birth }}
            </div>
          </div>

          <label for="exampleInputPassword1">Giới tính <span>(*)</span></label>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              name="exampleRadios"
              id="exampleRadios1"
              value="option1"
              @click="gender = 'male'"
              checked
            />
            <label class="form-check-label" for="exampleRadios1"> Nam </label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              name="exampleRadios"
              id="exampleRadios2"
              @click="gender = 'female'"
              value="option2"
            />
            <label class="form-check-label" for="exampleRadios2"> Nữ </label>
          </div>
          <br />
          <div class="form-group">
            <label for="exampleInputPassword1">Quê Quán <span>(*)</span></label>
            <input
              type="text"
              class="form-control"
              v-model="native_place"
              :class="{ 'is-invalid': errors.native_place }"
              @click="
                errorNative_place = null;
                errors.native_place = null;
              "
            />
            <div class="invalid-feedback">
              {{ errorNative_place }}
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"
              >Địa chỉ thường trú <span>(*)</span></label
            >
            <input
              type="text"
              class="form-control"
              v-model="address"
              :class="{ 'is-invalid': errors.address }"
              @click="
                errorAddress = null;
                errors.address = null;
              "
            />
            <div class="invalid-feedback">
              {{ errorAddress }}
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"
              >Địa chỉ tạm trú <span>(*)</span></label
            >
            <input
              type="text"
              class="form-control"
              v-model="address1"
              :class="{ 'is-invalid': errors.address1 }"
              @click="
                errorAddress1 = null;
                errors.address1 = null;
              "
            />
            <div class="invalid-feedback">
              {{ errorAddress1 }}
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Tôn giáo <span>(*)</span></label>
            <input
              type="text"
              class="form-control"
              v-model="religion"
              :class="{ 'is-invalid': errors.religion }"
              @click="
                errorReligion = null;
                errors.religion = null;
              "
            />
            <div class="invalid-feedback">
              {{ errorReligion }}
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"
              >Trình độ văn hóa <span>(*)</span></label
            >
            <input
              type="text"
              class="form-control"
              v-model="edu_level"
              :class="{ 'is-invalid': errors.edu_level }"
              @click="
                errorEdu_level = null;
                errors.edu_level = null;
              "
            />
            <div class="invalid-feedback">
              {{ errorEdu_level }}
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"
              >Nghề nghiệp <span>(*)</span></label
            >
            <input
              type="text"
              class="form-control"
              v-model="career"
              :class="{ 'is-invalid': errors.career }"
              @click="
                errorCareer = null;
                errors.career = null;
              "
            />
            <div class="invalid-feedback">
              {{ errorCareer }}
            </div>
          </div>
          <div>
            <label>Chú ý:</label> <span>(*)</span> là các trường bắt buộc nhập
          </div>
          <div class="btn btn-primary" @click="insertData()">Xác nhận</div>
          <div
            class="btn btn-danger"
            @click="
              open = false;
              id_card = null;
              full_name = null;
              date_of_birth = null;
              native_place = null;
              address = null;
              address1 = null;
              religion = null;
              edu_level = null;
              career = null;
            "
          >
            Làm mới
          </div>
        </form>
      </div>
      <br />
    </div>
  </div>
</template>
<script>
const axios = require("axios").default;
export default {
  props: {
    user: Object,
  },
  watch: {
    seC: {
      handler(value) {
        if (value > 0) {
          setTimeout(() => {
            this.seC--;
          }, 990);
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
      success: false,
      open: true,
      id_card: null,
      full_name: null,
      age: null,
      date_of_birth: null,
      gender: "male",
      native_place: null,
      address: null,
      address1: null,
      religion: null,
      edu_level: null,
      career: null,
      errors: {},

      errorFull_name: null,
      errorDate_of_birth: null,
      errorNative_place: null,
      errorAddress: null,
      errorAddress1: null,
      errorReligion: null,
      errorEdu_level: null,
      errorCareer: null,

      userActive: null,
      timeN: null,
      allowOpen: null,
      allowClose: null,
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
    insertData() {
      axios
        .post("/api/popdata", {
          code: this.user.city_code,
          id_card: this.id_card,
          full_name: this.full_name,
          date_of_birth: this.date_of_birth,
          age: this.age,
          gender: this.gender,
          native_place: this.native_place,
          address: this.address,
          address1: this.address1,
          religion: this.religion,
          edu_level: this.edu_level,
          career: this.career, 
        })
        .then((response) => {
          window.scrollTo(0, 0);
          this.success = true;
          this.id_card = null;
          this.full_name = null;
          this.date_of_birth = null;
          this.native_place = null;
          this.address = null;
          this.address1 = null;
          this.religion = null;
          this.edu_level = null;
          this.career = null;
          setTimeout(() => (this.success = false), 2000);
          //console.log(response);
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          //error full_name
          if (this.errors["full_name"] != undefined) {
            this.errorFull_name = this.errors["full_name"][0];
          } else {
            this.errorFull_name = null;
          }

          // error date_of_birth
          if (this.errors["date_of_birth"] != undefined) {
            this.errorDate_of_birth = this.errors["date_of_birth"][0];
          } else {
            this.errorDate_of_birth = null;
          }

          // error native_place
          if (this.errors["native_place"] != undefined) {
            this.errorNative_place = this.errors["native_place"][0];
          } else {
            this.errorNative_place = null;
          }

          //erro address
          if (this.errors["address"] != undefined) {
            this.errorAddress = this.errors["address"][0];
          } else {
            this.errorAddress = null;
          }

          // error address1
          if (this.errors["address1"] != undefined) {
            this.errorAddress1 = this.errors["address1"][0];
          } else {
            this.errorAddress1 = null;
          }
          // error religion
          if (this.errors["religion"] != undefined) {
            this.errorReligion = this.errors["religion"][0];
          } else {
            this.errorReligion = null;
          }
          // error edu
          if (this.errors["edu_level"] != undefined) {
            this.errorEdu_level = this.errors["edu_level"][0];
          } else {
            this.errorEdu_level = null;
          }
          // error career
          if (this.errors["career"] != undefined) {
            this.errorCareer = this.errors["career"][0];
          } else {
            this.errorCareer = null;
          }
        });
    },
  },
};
</script>
<style scoped>
label {
  font-weight: bold;
}
.main {
  margin-right: 50px;
}
span {
  color: red;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.8s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>