<template>
  <div class="header">
    <div class="header-avatar">
      <img v-bind:src="avatar"/>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {}
    },
    props: {
      avatar: {
        type: String,
        required: true
      }
    },
  }
</script>

<style scoped>
  .header {
    width: 100%;
    height: 2rem;
    background-image: linear-gradient(#03b7fe, #238afa);
  }

  .header-avatar {
    padding: 10px;
    height: 70px;
    width: 70px;
    border-radius: 50%;
  }

  .header-avatar > img {
    border-radius: 50%;
    height: 100%;
    width: 100%;
  }
</style>
