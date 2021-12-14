<template>
  <div>
    <!-- Biểu đồ  -->
    <div>
      <chart1-component
        v-if="open"
        :num="numOfCitizen"
        :chartData="chartData"
        :chartData1="chartData1" 
        :options="options"
      ></chart1-component>
    </div>
  </div>
</template>
<script>
const axios = require("axios").default;
export default {
  props: {
    user: Object,
  },
  mounted() {
    this.open = true;
    //console.log(this.user);
    axios
      .get("/api/chartallgender")
      .then((response) => {
        this.male = response.data[0];
        this.female = response.data[1];
        this.numOfCitizen = this.male + this.female;
        //console.log(response);
        this.chartData = {
          labels: ["Nam", "Nữ"],
          datasets: [
            {
              backgroundColor: ["#00ff37", "#00D8FF"],
              data: [this.male, this.female],
            },
          ],
        };
      }) 
      .catch((error) => {
        console.log(error);
      });

    axios
      .get("/api/chartallage")
      .then((response) => {
        this.first = response.data[0];
        this.second = response.data[1];
        this.third = response.data[2];
        //console.log(response);
        this.chartData1 = {
          labels: [
            "Dưới độ tuổi lao động",
            "Trong độ tuổi lao động",
            "Ngoài độ lao động",
          ],
          datasets: [
            {
              backgroundColor: ["#1500ff", "#f6ff00", "#ff0000"],
              data: [this.first, this.second, this.third],
            },
          ],
        };
      })
      .catch((error) => {
        console.log(error);
      });
  },
  data() {
    return {
      open: false,
      com_code: null,
      numOfCitizen: null,
      male: null,
      female: null,
      first: null,
      second: null,
      third: null,
      chartData: {},
      chartData1: {},
      options: {},
    };
  },
  methods: {},
};
</script> 
