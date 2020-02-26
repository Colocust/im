<template>
  <div class="nav">
    <div class="nav-box nav-box-left" @click="changeFocus(0)">
      <img v-bind:src="mImage"/>
      <div v-if="mNum > 0" class="messageNum nav-messageNum">
        {{ mNum }}
      </div>
      <div v-if="status === 'message'" class="nav-bottom"></div>
    </div>
    <div class="nav-box nav-box-middle" @click="changeFocus(1)">
      <img v-bind:src="fImage"/>
      <div v-if="status === 'friend'" class="nav-bottom"></div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {}
    },
    props: {
      fImage: {
        type: String,
        required: true
      },
      mImage: {
        type: String,
        required: true
      },
      status: {
        type: String,
        required: true
      },
      mNum:{
        type: Number,
        required: true
      }
    },
    methods: {
      changeFocus: function (focus) {
        this.$emit('changeFocus', focus);
      }
    }
  }
</script>

<style scoped>
  .nav {
    width: 90%;
    height: 0.75rem;
    background-color: #ffffff;
    position: absolute;
    left: 5%;
    top: 1.6rem;
    border-radius: 2rem;
  }

  .nav-box {
    width: 32%;
    display: inline-block;
    height: 0.75rem;
    line-height: 0.75rem;
    text-align: center;
    position: relative;
  }

  .nav-box-left {
    margin-right: 2%;
  }

  .nav-box-right {
    float: right;
  }

  .nav-box > img {
    vertical-align: middle;
    width: 40px;
    height: 40px;
  }

  .nav-bottom {
    width: 60px;
    height: 0.05rem;
    background-color: #0474e9;
    margin: auto;
  }

  .messageNum {
    position: absolute;
    width: 0.2rem;
    height: 0.2rem;
    border-radius: 50%;
    background-color: #fd575f;
    color: #ffffff;
    font-size: 12px;
    text-align: center;
    line-height: 0.2rem;
  }

  .nav-messageNum {
    right: 28%;
    top: 20%;
  }
</style>
