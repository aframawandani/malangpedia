<template>
  <div class="login-box">
    <div class="login-title">
      <h2><span style="font-weight: 300;">Malang</span><span style="font-weight: 600;">Pedia</span></h2>
    </div>
    <div class="login-box-body">
      <form @submit.prevent="submit">
        <div class="form-group">
          <input class="form-control" type="text" name="email" spellcheck="false" autocomplete="off" placeholder="Email" v-model="input.email">
          <i class="feather icon-user form-control-feedback"></i>
        </div>
        <div class="form-group">
          <input class="form-control" type="password" name="password" placeholder="Password" v-model="input.password">
          <i class="feather icon-lock form-control-feedback"></i>
        </div>
        <div class="d-flex justify-content-end">
          <button class="btn btn-primary btn-flat" type="submit">
            <span class="text">Masuk</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.login-title > h2 {
  font-size: 32px;
  text-align: center;
}

.login-image {
  margin: 0 auto 25px auto;
}
</style>

<script>
import axios from 'axios';

export default {
  metaInfo: {
    title: 'Masuk'
  },
  data() {
    return {
      isLoggingIn: false,
      message: null,
      input: {
        email: 'johndoe@example.com',
        password: 'secret'
      }
    }
  },
  methods: {
    submit() {
      this.isLoggingIn = true;
      this.message = null;

      const data = {
        email: this.input.email,
        password: this.input.password
      };

      axios({
        method: 'POST',
        url: '/api/auth/login',
        data
      })
      .then(response => {
        this.$inertia.visit('/admin');
      })
      .catch(error => {
        const message = error.response.data.message;

        if (typeof message === 'string') {
          this.message = message;
        }
      })
      .finally(() => {
        this.isLoggingIn = false;
      });
    }
  }
}
</script>
