<template>
  <div>
    <input v-model="content" class="message-input" placeholder="请输入内容"/>
    <button @click="sendMessage" class="message-btn">发送</button>
  </div>

</template>

<script>
  export default {
    data() {
      return {
        content: "",
      }
    },
    methods: {
      sendMessage: function () {
        this.$emit('sendMessage', this.content)
      },
      initInput() {
        this.content = "";
      }
    }
  }
</script>

<style scoped>
  .message-input {
    float: left;
    height: 0.5rem;
    width: 80%;
    text-indent: 10px;
    font-size: 16px;
    font-family: "Microsoft YaHei UI Light";
  }

  .message-btn {
    width: 20%;
    height: 0.5rem;
    background-image: linear-gradient(#03b7fe, #238afa);
    font-size: 16px;
    color: #fff;
    font-family: "Microsoft YaHei UI Light";
  }

</style>
