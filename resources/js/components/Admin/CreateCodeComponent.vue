<template>
  <div>
    <div
      class="btn btn-primary"
      v-show="create == false"
      @click="create = !create;success=null"
    >
      Tạo Code
    </div>
    <div class="btn btn-success" v-show="create==false">Xem mã đã tạo</div>
    <div class="form-group" v-show="create == true">
      <h3>Tạo mã cho TP <span>(từ 01 -> 63)</span></h3> 
      <label>Nhập code</label>
      <input
        type="text"
        class="form-control"
        id="exampleInputName"
        placeholder="Nhập code..."
        v-model="code"
        :class="{ 'is-invalid': error }"
        @click="error=null"
      />
      <div class="invalid-feedback">
          {{ error}}
      </div>
      <br>
      <div class="btn btn-primary" @click.prevent="createCode">Tạo</div>
      <div class="btn btn-danger" @click="create=false;error=null;code=null">Hủy</div>
    </div>
    <div class="alert alert-success" role="alert" v-show="success == true" style="margin-top: 10px">
      Tạo code thành công
    </div>
  </div>
</template>
<script>
import axios from 'axios';
export default {
  mounted() {},
  data() {
    return {
      create: false,
      code: null,
      error: null,
      success: null,
    };
  },
  methods: { 
      createCode(){
        if(this.code < 10 && this.code !=null){
          this.code = "0"+ Math.floor(this.code);
        }
          axios 
          .post('/api/admincreatecode',{
              code: this.code,
          })
          .then((response)=>{
              this.error = null;
              this.success =true;
              this.create = false;
              //console.log(response);
          })
          .catch((error)=>{
              this.error = error.response.data.errors['code'][0];
              //console.log(this.error); 
          })
      },
  },
};
</script>
<style scoped>
span {
  font-weight: bold;
  color: red;
}
</style>