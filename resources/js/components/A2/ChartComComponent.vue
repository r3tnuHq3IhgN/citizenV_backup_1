<template>
  <div>
    <!-- Lọc dữ liệu -->
    <div v-show="key == true">
      <multiselect
        v-model="selected"
        :options="key_com"
        :multiple="true"
        placeholder="Lựa chọn xã/phường"
        label="name"
        track-by="name" 
      >
      </multiselect>
      <br />
      <div class="btn btn-outline-primary" @click="bindData()">Lấy dữ liệu</div>
    </div>

    <!-- Thông báo lọc thành công --> 
    <div v-show="success == true" class="alert alert-success">
      Lọc thành công dữ liệu !
    </div>
    <div v-show="success == false" class="alert alert-danger">
      Không có quận/huyện nào được lựa chọn
    </div>

    <!-- Biểu đồ  -->
    <div>
      <chart-component 
        v-if="open"
        :num="numOfCitizen"
        :target="target"
        :target1="target1"
        :options="options"
        :leng="com_leng"
        :dis="model.com"
      ></chart-component>
    </div>

    <!-- Lọc tiếp -->
    <div v-show="key == false" class="btn btn-primary" @click="reloadPage()">
      Tiếp tục lọc
    </div>
  </div>
</template>
<script>
const axios = require("axios").default;
import Multiselect from "vue-multiselect";
export default {
  props: {
    user: Object,
  },
  components: {
    Multiselect,
  },
  mounted() {
    this.open = false;
    axios
      .get("/api/getcomofcity/" + this.user.city_code)
      .then((response) => {
        //this.district = response.data;
        // this.dis = response.data[0].district;
        for (var i = 0; i < response.data.length; i++) {
          this.key_com.push({ name: response.data[i].commune });
        }
      })
      .catch((error) => {
        console.log(error);
      });
  },
  data() {
    return {
      selected: null,
      key_com: [],
      key: true,
      open: false,
      dataN: {},
      model: {
        com: [],
      },
      com_code: null,
      numOfCitizen: [],
      male: {},
      female: {},
      first: {},
      second: {},
      third: {},
      target: [],
      target1: [],
      chartData1: {},
      options: {},
      com_leng: null,
      success: null,
    };
  },
  methods: {
    bindData() {
      this.key = false;
      this.open = true;
      if (this.selected != null) {
        this.com_leng = this.selected.length;

        for (var i = 0; i < this.com_leng; i++) {
          this.success=true;
          this.model.com.push(this.selected[i].name);
          axios
            .get("/api/getcodeofcom/" + this.selected[i].name)
            .then((response) => {
              this.com_code = response.data[0]["com_code"];
              axios
                .get("/api/chartgendermain/" + this.com_code) 
                .then((response) => {
                  this.male[i] = response.data[0];
                  this.female[i] = response.data[1];
                  this.numOfCitizen.push(this.male[i] + this.female[i]);
                  //console.log(response);
                  this.target.push({
                    labels: ["Nam", "Nữ"],
                    datasets: [
                      {
                        backgroundColor: ["#00ff37", "#00D8FF"],
                        data: [this.male[i], this.female[i]],
                      },
                    ],
                  });
                })
                .catch((error) => {
                  console.log(error);
                });

              axios
                .get("/api/chartagemain/" + this.com_code)
                .then((response) => {
                  this.first[i] = response.data[0];
                  this.second[i] = response.data[1];
                  this.third[i] = response.data[2];
                  //console.log(response);
                  this.target1.push({
                    labels: [
                      "Dưới độ tuổi lao động",
                      "Trong độ tuổi lao động",
                      "Ngoài độ lao động",
                    ],
                    datasets: [
                      {
                        backgroundColor: ["#1500ff", "#f6ff00", "#ff0000"],
                        data: [this.first[i], this.second[i], this.third[i]],
                      },
                    ],
                  });
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
      else{
        this.success=false;
      }
      this.options = {
        responsive: true,
        maintainAspectRatio: false,
      };
    },
    reloadPage() {
      window.location.reload();
    },
  },
};
</script> 
<style src="vue-multiselect/dist/vue-multiselect.min.css">
