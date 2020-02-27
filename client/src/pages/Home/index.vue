<template>
  <div class="body">
    <home-header
      :avatar="avatar"
    />
    <home-nav
      :mImage="imgUrl[0]"
      :fImage="imgUrl[1]"
      :status="status"
      :mNum="notReadMessageNum"
      @changeFocus="changeFocus"
    />

    <ul class="message-list">
      <home-message v-if="status === 'message'"
                    v-for="item of roomList"
                    :key="item.roomId"
                    :id="item.memberId"
                    :avatar="item.memberAvatar"
                    :nickname="item.memberNickname"
                    :time="item.lastSendTime"
                    :message="item.lastMessage"
                    :num="item.notReadNum"
                    @clickRoom="clickRoom"
      />
    </ul>
    <ul class="friend-list">
      <home-friend v-if="status === 'friend'"
                   v-for="item of userList"
                   :key="item.id"
                   :id="item.id"
                   :avatar="item.avatar"
                   :nickname="item.nickname"
                   @clickRoom="clickRoom"
      />
    </ul>
  </div>
</template>
<script>
  import https from "../../https";
  import HomeHeader from './components/header'
  import HomeNav from './components/nav'
  import HomeFriend from './components/friend'
  import HomeMessage from './components/message'

  const ImgUrlDefault = [
    require("../../assets/images/message.png"),
    require("../../assets/images/friend.png")
  ];
  const ImgUrlFocus = [
    require("../../assets/images/message-focus.png"),
    require("../../assets/images/friend-focus.png")
  ];

  export default {
    components: {
      HomeHeader,
      HomeNav,
      HomeFriend,
      HomeMessage
    },
    beforeCreate() {
      document
        .getElementsByTagName("body")[0]
        .setAttribute("style", "background-color:#F2F6FC");
    },
    mounted() {
      document.title = "im"
    },
    created() {
      let ids = [localStorage.getItem("uid")];
      this.getMyAvatar(ids);
      this.getMyUser();
      this.getMyRoom();
      this.initWebsocket();
    },
    name: "Index",
    data() {
      return {
        avatar: "",
        imgUrl: [ImgUrlFocus[0], ImgUrlDefault[1]],
        status: "message",
        notReadMessageNum: 0,
        roomList: [],
        userList: [],
        websocket: null
      };
    },
    methods: {
      initWebsocket: function () {
        const WS_URL = "ws://120.79.59.196:9501?uid=" + localStorage.getItem('uid');
        this.websock = new WebSocket(WS_URL);
        this.websock.onmessage = this.websocketOnmessage;
        this.websock.onopen = this.websocketOnopen;
        this.websock.onerror = this.websocketOnerror;
        this.websock.onclose = this.websocketOnclose;
      },
      websocketOnopen: function () {

      },
      websocketOnmessage: function (e) {
        this.roomList = [];
        this.getMyRoom();
      },
      websocketOnerror: function () {

      },
      websocketOnclose: function () {

      },
      clickRoom: function (uid) {
        this.$router.push({path: "Room", query: {uid: uid}});
      },

      changeFocus: function (focus) {
        for (let i = 0; i < 2; i++) {
          this.imgUrl[i] = ImgUrlDefault[i];
        }
        this.imgUrl[focus] = ImgUrlFocus[focus];
        this.status = focus ? "friend" : "message";
      },

      getMyAvatar: function (ids) {
        let params = {
          ids: ids,
          fields: ["avatar"]
        };
        https.fetchPost("GetUserInfo", params).then(res => {
          this.avatar = res.data.items[0].avatar;
        }).catch(err => {
          console.log(err);
        });
      },

      getMyUser: function () {
        let params = {};
        //获取平台内所有用户
        https
          .fetchPost("GetUserList", params)
          .then(res => {
            let userIds = [];
            res.data.ids.forEach(item => {
              if (item !== localStorage.getItem("uid")) {
                userIds.push(item);
              }
            });
            //获取用户详情
            let params = {
              ids: userIds,
              fields: ["avatar", "nickname"]
            };
            https.fetchPost("GetUserInfo", params).then(res => {
              res.data.items.forEach(one => {
                let item = {
                  id: one.id,
                  nickname: one.nickname,
                  avatar: one.avatar
                };
                this.userList.push(item);
              });
            }).catch(err => {
              console.log(err);
            });
          }).catch(err => {
          console.log(err);
        });
      },

      getMyRoom: function () {
        let allNotReadNum = 0;
        https.fetchPost("GetMyRoom", {}).then(res => {
          res.data.items.forEach(one => {
            let message = one.lastMessage;
            message =
              message.length > 10 ? message.substr(0, 10) + "..." : message;
            let item = {
              roomId: one.roomId,
              memberId: one.memberId,
              memberNickname: one.memberNickname,
              memberAvatar: one.memberAvatar,
              lastMessage: message,
              lastSendTime: one.lastSendTime,
              notReadNum: one.notReadNum
            };
            this.roomList.push(item);
            allNotReadNum += one.notReadNum;
          });
          this.notReadMessageNum = allNotReadNum;
        }).catch(err => {
          console.log(err);
        });
      }
    }
  };
</script>

<style scoped lang="scss">
  .body {
    height: 100%;
    width: 100%;
    background-color:#F2F6FC;
    padding-bottom: 2%;
  }

  .message-list {
    margin-top: 20%;
    width: 100%;
    margin-bottom: 20%;
  }

  .friend-list {
    margin-top: 20%;
    width: 100%;
  }
</style>
