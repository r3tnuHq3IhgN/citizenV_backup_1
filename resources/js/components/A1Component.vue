<template>
  <div>
    <h1>Thống kê user</h1>
    <div class="table-wrapper-scroll-y my-custom-scrollbar">
      <table class="table table-bordered table-striped mb-0">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Active</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="index">
            <td>{{ index+1 }}</td>
            <th scope="row">{{ user.name }}</th>
            <td>{{ user.email }}</td>
            <td>{{ user.role }}</td>
            <td>
              <!-- <a @click="removeUser(user.id)"
                ><i class="fa fa-trash mr-3" aria-hidden="true"></i
              ></a> -->
              <button class="btn btn-danger" @click="removeUser(user.id)">
                Xóa
              </button>
              <button class="btn btn-primary">Sửa</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
const axios = require("axios").default;
export default {
  mounted() {
    axios
      .get("/api/alluser")
      .then((response) => {
        this.users = response.data;
        //console.log(response.data);
      })
      .catch((error) => {
        // console.log(error);  
      });
  },
  data() {
    return {
      users: {},
      edit: false,
      tg: null,
    };
  },
  methods: {
    removeUser(id) {
      if (confirm("Bạn chắc chắn muốn xóa tài khoản này ?")) {
        axios
          .delete("/api/remove/" + id)
          .then((response) => {
            this.users = response.data;
            //console.log(response);
          })
          .catch((error) => {
            // console.log(error);
          });
      }
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
