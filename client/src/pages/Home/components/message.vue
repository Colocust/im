<template>
  <li class="message-item" @click="clickRoom(id)">
    <div class="message-avatar">
      <img v-bind:src="avatar"/>
    </div>
    <div class="message-box">
      <div class="message-top">
        <p class="message-p-name">{{ nickname }}</p>
        <p class="message-p-time">{{ time }}</p>
        <div v-if="num > 0" class="messageNum item-messageNum">
          {{ num }}
        </div>
      </div>
      <div class="message-content">
        {{ message }}
      </div>
    </div>
  </li>
</template>

<script>
  export default {
    data() {
      return {}
    },
    props: {
      id: {
        type: String,
        required: true
      },
      avatar: {
        type: String,
        required: true
      },
      nickname: {
        type: String,
        required: true
      },
      time: {
        type: String,
        required: true
      },
      message: {
        type: String,
        required: true
      },
      num: {
        type: Number,
        required: true
      }
    },
    methods: {
      clickRoom: function (member) {
        this.$emit('clickRoom', member);
      }
    }
  }
</script>

<style scoped>
  .message-item {
    width: 90%;
    height: 1rem;
    margin: auto auto 0.1rem auto;
    background-color: #ffffff;
    display: flex;
    align-items: center;
  }

  .message-item > div {
    display: inline-block;
  }

  .message-avatar {
    width: 0.55rem;
    height: 0.55rem;
    margin-left: 10px;
  }

  .message-avatar > img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
  }

  .message-box {
    height: 100%;
    width: 70%;
    margin-left: 5%;
    text-align: left;
  }

  .message-top {
    height: 0.5rem;
    line-height: 0.5rem;
    position: relative;
  }

  .message-top > p {
    display: inline-block;
  }

  .message-p-name {
    font-size: 18px;
    color: #000;
  }

  .message-p-time {
    font-size: 12px;
    float: right;
    color: #838283;
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

  .item-messageNum {
    right: -11%;
    top: -20%;
  }

  .message-content {
    line-height: 30px;
    height: 50%;
    font-size: 16px;
    color: #838283;
  }
</style>
