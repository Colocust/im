<template>
  <div class="register">
    <p class="register-title">注册</p>
    <div class="register-box">
      <input
        class="register-input"
        placeholder="输入手机号"
        v-model="phone"
        type="number"
      />
      <div class="captcha-box">
        <input
          class="register-input register-captcha-input"
          placeholder="输入验证码"
          v-model="captcha"
          type="number"
        />
        <button
          v-if="show"
          class="register-input register-code-input "
          @click="getCaptcha"
        >
          {{ tips }}
        </button>
        <button v-if="!show" class="register-input register-code-input">
          {{ second }}s
        </button>
      </div>
      <input
        class="register-input"
        placeholder="密码"
        v-model="password"
        type="password"
      />
      <div class="register-bottom">
        <router-link to="/login" class="register-bottom-btn">返回</router-link>
        <button class="register-bottom-btn" @click="register">注册</button>
      </div>
    </div>
  </div>
</template>

<script>
  import * as common from "../../lib/utils.js";
  import https from "../../https";

  export default {
    name: "Register",
    data() {
      return {
        phone: '',
        password: '',
        captcha: '',
        show: true,
        url: "login.html",
        second: 60,
        timer: null,
        tips: "获取验证码"
      };
    },
    mounted() {
      document.title = "注册"
    },
    methods: {
      getCaptcha: function () {
        if (common.checkPhone(this.phone).code) {
          alert("请输入正确的手机号");
          return;
        }

        let params = {
          telephone: this.phone
        };
        https.fetchPost("GetCaptcha", params).then(res => {
          if (res.data.result === 2) {
            this.show = false;
            this.timer = setInterval(() => {
              this.second > 0 ? this.second-- : this.initTimer();
            }, 1000);
          }
          if (res.data.result === 1) {
            alert("该手机号已被注册");
            return;
          }
          if (res.data.result === 0) {
            alert("发送失败");
            return;
          }
        }).catch(err => {
          console.log(err);
        });
      },

      initTimer: function () {
        clearInterval(this.timer);
        this.show = true;
        this.timer = null;
        this.second = 60;
        this.tips = "重新获取";
      },

      register: function () {
        let phoneCheck = common.checkPhone(this.phone);
        if (phoneCheck.code) {
          alert(phoneCheck.msg);
          return;
        }

        let passwordCheck = common.checkPassword(this.password);
        if (passwordCheck.code) {
          alert(passwordCheck.msg);
          return;
        }

        let captchaCheck = common.checkCaptcha(this.captcha);
        if (captchaCheck.code) {
          alert(captchaCheck.msg);
          return;
        }

        let params = {
          captcha: this.captcha,
          telephone: this.phone,
          password: this.password
        };
        https.fetchPost("RegisterUser", params).then(res => {
          if (res.data.result === 0) {
            alert("该手机号已被注册");
            return;
          }
          if (res.data.result === 1) {
            alert("验证码错误");
            return;
          }
          if (res.data.result === 2) {
            alert("注册失败");
            return;
          }
          if (res.data.result === 3) {
            this.$router.push("/login");
          }
        }).catch(err => {
          console.log(err);
        });
      }
    }
  };
</script>

<style scoped lang="scss">
  .register {
    width: 100%;
    height: 100%;
  }

  .register-title {
    text-align: center;
    font-size: 0.4rem;
    padding: 0.5rem 0;
  }

  .register-input {
    font-family: "Microsoft YaHei UI Light";
    font-size: 16px;
    display: block;
    border: transparent;
    margin-left: 10%;
    height: 0.7rem;
    background-color: #ececec;
    width: 80%;
    border-radius: 5rem;
    margin-bottom: 40px;
    text-align: center;
    line-height: 30px;
    outline: none;
  }

  .captcha-box {
    margin: auto;
    text-align: left;
    width: 80%;
  }

  .captcha-box > input {
    margin-left: 0;
  }

  .register-captcha-input {
    display: inline-block;
    width: 60%;
  }

  .register-code-input {
    display: inline-block;
    width: 30%;
    float: right;
    margin-left: 0;
    background-color: #1e91fe;
    color: #ffffff;
  }

  .register-bottom {
    width: 100%;
  }

  .register-bottom > a {
    float: left;
    text-decoration: none;
    text-align: center;
    line-height: 0.5rem;
    margin-left: 10%;
  }

  .register-bottom-btn {
    width: 1.2rem;
    height: 0.5rem;
    float: right;
    border-radius: 5rem;
    font-size: 16px;
    border: none;
    background-color: #1e91fe;
    margin-right: 10%;
    color: #ffffff;
    font-family: "Microsoft YaHei UI Light";
  }
</style>
