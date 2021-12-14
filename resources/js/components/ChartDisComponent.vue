<template>
<div>
  <div v-for="index in leng" :key="index" class="boxbox">
    <h4>Số lượng người dân đã được nhập dữ liệu từ {{dis[index-1]}}: {{num[index-1]}}</h4>
    <div class="main">
      <div class="small">
        <h4>Tỉ lệ giới tính</h4>  
        <line-chart :chartData="target[index-1]" :options="options" />
      </div>
      <div class="small"> 
        <h4>Phân hóa độ tuổi lao động</h4>
        <line-chart :chartData="target1[index-1]" :options="options" /> 
        <div>
        </div>  
      </div> 
    </div>
  </div>
</div>
</template> 

<script>
import LineChart from "./LineChart";

export default {
  props: {
    target: {
    },
    target1: {
    },
    options: {
      type: Object,
      default: null,
    },
    num: {

    },
    dis: {

    },
    leng: Number,
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
div > h5 {
  margin-top: 10px;
}
span {
  font-weight: bold;
  color: red;
}
h5 {
  text-align: center;
}
.boxbox{
  border-top: 1px solid #bababa;
  padding-top: 10px;
}
</style> 