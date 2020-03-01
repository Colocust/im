<template>
  <li
    class="message-item"
    :class="{
      'is-right': isRight
    }"
  >
    <div class="content-wrapper">
      <div class="message-time">
        {{ time }}
      </div>
      <div class="message-content">{{ content }}</div>
    </div>
    <img v-if="avatar" :src="avatar" class="message-avatar"/>
  </li>
</template>
message-content
<script>
  export default {
    props: {
      isRight: {
        type: Boolean,
        default: false
      },
      time: {
        type: String
      },
      content: {
        type: String
      },
      avatar: {
        type: String
      }
    },
    data() {
      return {}
    },
    methods: {}
  }
</script>

<style lang="scss" scoped>
  .message-item {
    display: flex;
    justify-content: flex-start;
    position: relative;
    width: 100%;
    padding-top: .4rem;
    text-align: left;
    border-radius: 5px;
    margin-bottom: .2rem;

    &.is-right {
      justify-content: flex-end;

      .message-time {
        left: .2rem;
      }

      .message-avatar {
        right: -16px;
        left: auto;
      }

    }

    .content-wrapper {
      position: relative;
      width: 78vw;
    }

    .message-time {
      position: absolute;
      top: -.2rem;
      right: .2rem;
      font-size: 14px;
      color: #a9acaa;
    }

    .message-content {
      font-size: 16px;
      margin-top: .2rem;
      padding: .2rem;
      border-radius: 10px;
      background-color: #fff;
      box-sizing: border-box;
      word-break: break-all;
    }

    .message-avatar {
      position: absolute;
      left: -16px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }
  }
</style>
