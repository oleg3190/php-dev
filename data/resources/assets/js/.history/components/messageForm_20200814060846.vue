<template>
  <div>
    <form v-if="user" action method="post" class="form-horizontal">
      <div ref="error_msg" v-if="textNull" class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Ошибка!</strong> Сообщение не может быть пустым.
      </div>

      <div class="controls">
        <div class="col-md-12">
          <div class="form-group">
            <label for="message_text">Текст сообщения:</label>
            <textarea
              id="message_text"
              name="message_text"
              class="form-control"
              placeholder="Ваше сообщение"
              rows="4"
              v-model="text"
            ></textarea>
          </div>
        </div>
        <div class="col-md-12 text-center">
          <input
            ref="button"
            type="submit"
            @click.prevent="checkText()"
            class="btn btn-success btn-send"
            value="Отправить сообщение"
          />
        </div>
      </div>
    </form>
    <div class="row wall-message" v-for="(message, index) in messages" :key="index">
      <div v-if="loading && arrIndex == index" class="lds-ellipsis">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
      <button
        v-if="isAuthor(message) || isAdmin()"
        @click="deleteMessage(message.id,index)"
        type="button"
        class="close"
        aria-hidden="true"
      >&times;</button>

      <div class="col-md-1 col-xs-2">
        <img src="http://www.gravatar.com/robohash/hash.jpg" alt class="img-circle user-avatar" />
      </div>
      <div class="col-md-11 col-xs-10">
        <p>
          <strong>{{message.author}}</strong>
        </p>
        <blockquote>{{message.text}}</blockquote>
      </div>
    </div>
    <infinite-loading @distance="5" @infinite="infiniteHandler">
      <div slot="spinner">Загрузка...</div>
      <div slot="no-more">Больше нет сообщений</div>
      <div slot="no-results">Ещё никто не оставил сообщение</div>
    </infinite-loading>
  </div>
</template>

<script>
export default {
  props: ["user"],
  data: () => ({
    text: "",
    page: 0,
    textNull: false,
    messages: [],
    loading: false,
    arrIndex: "",
  }),
  mounted() {
    window.Echo.channel("chat").listen("Message", ({ message }) => {
      switch (message.action) {
        case "remove":
          this.messages.splice(message.index, 1);
          break;
        case "create":
          this.messages.unshift(message);
          break;

        case "error":
          this.error = message.error;
        default:
        //
      }
      this.loading = false;

      if (message.remove === undefined) {
        this.messages.unshift(message);
      } else if (message.error) {
        this.loading = false;
      } else {
        this.messages.splice(message.remove, 1);
      }

      if (this.loading) this.loading = false;
    });
  },
  methods: {
    isAuthor(message) {
      if (this.user) {
        return this.user.login === message.author;
      }
    },
    isAdmin() {
      if (this.user) {
        return this.user.role !== "user";
      }
    },
    checkText() {
      if (this.text) {
        this.sentMessage();
        this.text = "";
        this.textNull = false;
      } else {
        this.textNull = true;
      }
    },
    sentMessage() {
      this.loading = true;
      axios({
        method: "post",
        url: "/cabinet/message/store",
        data: {
          user_from: this.user.id || null,
          text: this.text,
        },
      })
        .then((response) => {})
        .catch((error) => {});
    },
    deleteMessage(id, index) {
      this.loading = true;
      this.arrIndex = index;
      axios({
        method: "post",
        url: "/cabinet/message/destroy/" + id,
        data: {
          owner: this.user.id,
          index: index,
        },
      })
        .then((response) => {})
        .catch((error) => {});
    },
    infiniteHandler($state) {
      axios({
        method: "post",
        url: "/messages/?page=" + this.page,
      })
        .then((response) => {
          if (response.data.data.length) {
            this.page += 1;
            this.messages.push(...response.data.data);
            $state.loaded();
          } else {
            $state.complete();
          }
        })
        .catch((error) => {});
      this.page = this.page + 1;
    },
  },
};
</script>

