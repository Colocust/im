<template>
  <header class="header-container">
    <img
      src="../../../assets/images/back.png"
      class="header-img header-back"
      @click="handleBack"
    />
    <p class="header-title">{{ _title }}</p>
    <img :src="avatar" class="header-img header-avatar"/>
  </header>
</template>

<script>
  export default {
    props: {
      _title: {
        type: String,
        required: true
      },
      avatar: {
        type: String,
        required: true
      }
    },
    data() {
      return {}
    },
    methods: {
      handleBack() {
        this.$emit('back')
      }
    }
  }
</script>

<style lang="scss" scoped>
  .header-container {
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 1.1rem;
    text-align: center;
    background-image: linear-gradient(#03b7fe, #238afa);
    z-index: 1;
  }

  .header-title {
    flex: 1;
    font-size: 16px;
    color: #fff;
  }

  .header-avatar {
    right: 5%;
    border-radius: 50%;
  }

  .header-img {
    position: absolute;
    right: .2rem;
    width: 40px;
    height: 40px;
  }

  .header-back {
    left: 0;
  }
</style>
