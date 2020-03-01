<template>
  <div class="room-wrapper" id="room-wrapper">
    <room-header
      :_title="senderInfo.nickname"
      :avatar="senderInfo.avatar"
      @back="handleBack"
    />
    <ul class="message-list" id="message-list">
      <message-item
        v-for="item of messageList"
        :key="item.id"
        :is-right="!!item.float"
        :time="item.time"
        :content="item.content"
        :avatar="item.avatar"
      />
    </ul>
    <room-input class="room-input"
                @sendMessage="sendMessage"
                ref="input"
                :content="content"/>
  </div>
</template>

<script>
  import RoomHeader from './components/header.vue'
  import MessageItem from './components/messageItem.vue'
  import RoomInput from './components/input.vue'
  import Util from '../../lib/utils'
  import https from "../../https";
  import md5 from 'js-md5';

  export default {
    name: 'Room',
    components: {
      RoomHeader,
      MessageItem,
      RoomInput
    },
    mounted() {
      document.title = '房间'
    },
    beforeCreate() {
      document.getElementsByTagName('body')[0].setAttribute('style', 'background-color:#F2F6FC')
    },
    created() {
      this.senderToUid = this.$route.query.uid;
      this.getMemberInfo([this.senderToUid, localStorage.getItem('uid')]);
      this.getMessageList(this.senderToUid);
      this.initWebsocket();
    },
    destroyed() {
      this.websocket.onclose = this.websocketOnclose
    },
    updated() {
      let ele = document.getElementById('message-list');
      this.$nextTick(() => {
        document.documentElement.scrollTop = ele.scrollHeight;
      });
    },
    data() {
      return {
        senderInfo: {
          id: null,
          avatar: '',
          nickname: ''
        },
        selfInfo: {
          id: null,
          avatar: null,
          nickname: null
        },
        senderToUid: null,
        messageList: [],
        websocket: null,
        content: ""
      }
    },
    methods: {
      initWebsocket: function () {
        const WS_URL = "ws://127.0.0.1:9501?uid=" + localStorage.getItem('uid');
        this.websocket = new WebSocket(WS_URL);
        this.websocket.onmessage = this.websocketOnmessage;
        this.websocket.onopen = this.websocketOnopen;
        this.websocket.onerror = this.websocketOnerror;
        this.websocket.onclose = this.websocketOnclose;
      },
      websocketOnopen: function () {
        console.log('连接成功')
      },
      websocketOnmessage: function (e) {
        let data = JSON.parse(e.data);
        this.messageList.push({
          id: data.id,
          uid: data.senderUid,
          time: Util.getDate(data.createAt),
          content: data.message,
          float: 0,
          avatar: this.senderInfo.avatar,
          state: 0
        });
        this.readMessage();
      },
      websocketOnerror: function () {

      },
      websocketOnclose: function () {
        console.log('关闭成功')
      },
      websocketSendMessage: function (data) {
        this.websocket.send(data)
      },
      handleBack() {
        this.$router.push('/')
      },
      sendMessage(content) {
        let createAt = Date.parse(new Date());
        let id = md5(localStorage.getItem('uid') + this.senderToUid + content + createAt);
        let message = {
          id: id,
          uid: localStorage.getItem('uid'),
          time: Util.getDate(createAt),
          content: content,
          float: 1,
          avatar: this.selfInfo.avatar
        };
        this.messageList.push(message);
        this.$refs.input.initInput();
        let data = {
          id: id,
          senderUid: localStorage.getItem('uid'),
          receiveUid: this.senderToUid,
          message: content,
          createAt: createAt
        };
        this.websocketSendMessage(JSON.stringify(data));
      },
      getMemberInfo(ids) {
        let params = {
          ids: ids,
          fields: ['avatar', 'nickname']
        };
        https.fetchPost('GetUserInfo', params).then(res => {
          res.data.items.forEach(item => {
            if (item.id !== localStorage.getItem('uid')) {
              this.senderInfo = Object.assign({}, item)
            } else {
              this.selfInfo = Object.assign({}, item)
            }
          })
        }).catch(err => {
          console.log(err)
        })
      },

      readMessage() {
        let messageIds = [];
        this.messageList.forEach(item => {
          if (item.uid !== localStorage.getItem('uid') && item.state === 0) {
            messageIds.push(item.id);
          }
        });
        if (messageIds.length > 0) {
          let params = {
            messageIds: messageIds,
          };
          https.fetchPost('ReadMessage', params).then(res => {
            console.log('阅读成功')
          }).catch(err => {
            console.log(err)
          })
        }
      },

      getMessageList(uid) {
        let params = {
          memberId: uid
        };
        https.fetchPost('GetRoomByMembers', params).then(res => {
          let params = {
            roomId: res.data.roomId
          };

          https.fetchPost('GetMessageByRoomId', params).then(res => {
            const data = res.data.items;
            this.messageList = data.map(item => ({
              id: item.id,
              uid: item.senderUid,
              time: item.createAt,
              content: item.content,
              float: item.float,
              avatar: item.float
                ? this.selfInfo.avatar
                : this.senderInfo.avatar,
              state: item.state
            }));
            this.readMessage();
          }).catch(err => {
          })
        }).catch(err => {
          console.log(err)
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
  .room-wrapper {
    padding-top: 1.1rem;
    height: 100%;
    background-color: #F2F6FC
  }

  .message-list {
    padding: 0.4rem 0.6rem 0;
    overflow-y: auto;
    overflow-x: hidden;
    margin-bottom: 0.5rem;
  }

  .room-input {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 0.5rem;
    background-color: rgb(248, 248, 248);
    z-index: 9999;
  }

</style>
