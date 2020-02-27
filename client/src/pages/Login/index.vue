<template>
  <div class="login">
    <p class="login-title">im</p>
    <input
      class="login-input"
      placeholder="手机号"
      v-model="phone"
      type="number"
      v-on:input="phoneInput"
    />
    <input
      class="login-input"
      placeholder="密码"
      v-model="password"
      type="password"
      v-on:input="passwordInput"
    />
    <div class="login-btn" id="login-btn" v-on:click="login">
      <img class="login-img" v-bind:src="imgUrl"/>
    </div>
    <div class="login-tab">
      <router-link to="/register">注册</router-link>
    </div>
  </div>
</template>

<script>
  const ImgUrl = {
    default: require("../../assets/images/login-btn-n.png"),
    focus: require("../../assets/images/login-btn.png")
  };

  import https from "../../https";
  import * as common from "../../lib/utils.js";

  export default {
    name: "Login",
    data() {
      return {
        phone: "",
        password: "",
        imgUrl: require("@/assets/images/login-btn-n.png"),
        status: false
      };
    },
    mounted() {
      document.title = "登录"
    },
    methods: {
      phoneInput: function () {
        this.checkStatus(this.phone, this.password);
      },
      passwordInput: function () {
        this.checkStatus(this.phone, this.password);
      },
      login: function () {
        if (this.status) {
          let res = common.checkPhone(this.phone);
          if(res.code) {
            alert("请输入正确的手机号");
            return;
          }
          let params = {
            telephone: this.phone,
            password: this.password
          };
          https.fetchPost("UserLogin", params).then(res => {
            if (res.data.result === 2) {
              localStorage.setItem("token", res.data.token);
              localStorage.setItem("uid", res.data.uid);
              this.$router.push("/");
            }
            if (res.data.result === 0) {
              alert("没有该用户");
              return;
            }
            if (res.data.result === 1) {
              alert("密码错误");
              return;
            }
          })
            .catch(err => {
              console.log(err);
            });
        }
      },
      checkStatus(phone, password) {
        let status = true;
        if (phone === "" || password === "") {
          status = false;
        }
        this.status = status;
        this.imgUrl = status ? ImgUrl.focus : ImgUrl.default;
      }
    }
  };
</script>
<style scoped lang="scss">
  .login {
    width: 100%;
    height: 100%;
  }

  .login-title {
    text-align: center;
    font-size: 0.5rem;
    padding: 0.5rem 0;
  }

  .login-input {
    font-family: "Microsoft YaHei UI Light";
    display: block;
    border: transparent;
    height: 0.7rem;
    background-color: #ececec;
    width: 80%;
    border-radius: 5rem;
    margin-left: 10%;
    margin-bottom: 40px;
    font-size: 16px;
    text-align: center;
    line-height: 30px;
    outline: none;
  }

  .login-btn {
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 99rem;
    background-color: #e0e0e0;
    margin: 1rem auto auto auto;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .login-btn > img {
    width: 0.4rem;
    height: 0.4rem;
  }

  .login-tab {
    position: fixed;
    bottom: 1rem;
    width: 100%;
    font-size: 16px;
    text-align: center;
    font-family: "Microsoft Yi Baiti";
  }

  .login-tab > a {
    text-decoration: none;
    color: #060614;
  }
</style>
