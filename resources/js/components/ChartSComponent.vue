<template>
  <div class="chart1">
    <h4>Số lượng người dân đã được nhập dữ liệu: {{ num }}</h4>
    <div class="main">
      <div class="small">
        <h4>Tỉ lệ giới tính</h4>
        <line-chart :chartData="chartData" :options="options" />
      </div>
      <div class="small">
        <h4>Phân hóa độ tuổi lao động</h4>
        <line-chart :chartData="chartData1" :options="options" />
      </div>
    </div>
  </div>
</template> 

<script>
import LineChart from "./LineChart";

export default {
  props: {
    chartData: {
      type: Object,
      default: null,
    },
    chartData1: {
      type: Object,
      default: null,
    },
    options: {
      type: Object,
      default: null,
    },
    num: Number,
  },
  components: {
    LineChart,
  },
  mounted() {
    //console.log("render");
  },
  data() {
    return {};
  },
  methods: {},
};
</script>

<style scoped>
.small {
  max-width: 500px;
  margin: 50px 0px;
}
h4 {
  text-align: center;
}
.main {
  display: flex;
  justify-content: center;
}
.chart1{
    margin-top: 50px;
}
</style> 