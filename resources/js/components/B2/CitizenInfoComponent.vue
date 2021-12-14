<template>
  <div>
    <h3>Thông tin về người dân đã nhập</h3>
    <div class="table-wrapper-scroll-y my-custom-scrollbar">
      <table class="table table-bordered table-striped mb-0">
        <thead>
          <tr>
            <th scope="col">Số CMND/CCCD</th>
            <th scope="col">Họ và tên</th>
            <th scope="col">Ngày sinh</th>
            <th scope="col">Giới tính</th>
            <th scope="col">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(citizen,index) in citizens" :key="index">
            <td>{{citizen.id_card}}</td>
            <th scope="row">{{citizen.full_name}}</th>
            <td>{{citizen.date_of_birth}}</td>
            <td>{{citizen.gender}}</td>
            <td>
                <div class="btn btn-primary" @click="cNow = citizen;more=true">Xem thêm</div>
                <div class="btn btn-danger">Sửa</div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-show="more==true">
      <div class="alert alert-secondary">Thông tin thêm về người dân này</div>
      <div><label>Số CMND/CCCD: </label> {{cNow.id_card}}</div>
       <div><label>Họ và tên: </label>{{cNow.full_name}}</div>
       <div><label>Ngày sinh: </label>{{cNow.date_of_birth}}</div>
       <div><label>Giới tính: </label>{{cNow.gender}}</div>
       <div><label>Quê quán: </label>{{cNow.native_place}}</div>
       <div><label>Nơi thường trú: </label>{{cNow.address}}</div>
       <div><label>Nơi tạm trú: </label>{{cNow.address1}}</div>
       <div><label>Tôn giáo: </label>{{cNow.religion}}</div>
       <div><label>Trình độ học vấn: </label>{{cNow.edu_level}}</div>
       <div><label>Nghề nghiệp: </label>{{cNow.career}}</div>
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
      axios
      .get('/api/getcitizen/'+ this.user.city_code)
      .then((response) => {
          this.citizens = response.data;
          //console.log(response)
      })
      .catch((error) => {
          console.log(error);  
      })
  }, 
  data() {
    return {
        citizens: {},
        cNow: {},
        more: null,
    };
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
label{
  font-weight: bold;
}
</style>