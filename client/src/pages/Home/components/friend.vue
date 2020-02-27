<template>
  <li class="friend-item" @click="clickRoom(id)">
    <div class="friend-avatar">
      <img v-bind:src="avatar"/>
    </div>
    <div class="friend-name">{{ nickname }}</div>
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
    },
    methods: {
      clickRoom: function (member) {
        this.$emit('clickRoom', member);
      }
    }
  }
</script>

<style scoped>
  .friend-item {
    width: 95%;
    height: 1rem;
    margin: auto auto 0.1rem auto;
    background-color: #ffffff;
    display: flex;
    align-items: center;
    border-radius: 1rem;
  }

  .friend-item > div {
    display: inline-block;
  }

  .friend-avatar {
    margin-left: 0.2rem;
    width: 0.5rem;
    height: 0.5rem;
  }

  .friend-avatar > img {
    width: 100%;
    height: 100%;
    border-radius: 5px;
  }

  .friend-name {
    text-align: left;
    height: 100%;
    width: 70%;
    font-size: 16px;
    padding-left: 0.2rem;
    line-height: 1rem;
  }
</style>
