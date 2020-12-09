<template>
  <div class="login-page">
    <div class="container h-100">
      <div class="row justify-content-center align-content-center h-100">
        <div class="col-auto">
          <h1 class="malangpedia-text">Malang<strong>Pedia</strong></h1>
          <div class="card" style="width: 360px;">
            <div class="card-body login-card-body">
              <h4 class="login-box-msg">Masuk</h4>
              <form @submit.prevent="signinFormOnSubmit">
                <div class="form-group">
                  <input v-bind:class="`form-control${errors.email instanceof Array ? ' is-invalid' : ''}`" type="email" name="email" spellcheck="false" autocomplete="off" placeholder="Email" v-model="input.email">
                  <small v-for="(error, i) in errors.email" v-bind:key="i" class="form-text text-danger">{{error}}</small>
                </div>
                <div class="form-group">
                  <input v-bind:class="`form-control${errors.password instanceof Array ? ' is-invalid' : ''}`" type="password" name="password" spellcheck="false" autocomplete="off" placeholder="Password" v-model="input.password">
                  <small v-for="(error, i) in errors.password" v-bind:key="i" class="form-text text-danger">{{error}}</small>
                </div>
                <div class="d-flex justify-content-end">
                  <button class="btn btn-primary w-100" v-bind:disabled="isSigningIn">
                    <i v-if="isSigningIn" class="feather icon-loader"></i>
                    <span class="text">{{isSigningIn ? 'Menyambungkan' : 'Masuk'}}</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.malangpedia-text {
  font-size: 32px;
  font-weight: 200;
  margin-bottom: 20px;
  text-align: center;
}

.login-page {
  background-color: #e9ecef;
  height: 100%;
}

.login-box-msg {
  font-size: 16px;
  margin-bottom: 16px;
}

.form-control {
  box-shadow: none !important;
  font-size: 14px;
}

.btn {
  font-size: 14px;
}

.input-group-append > .input-group-text {
  background-color: transparent;
}

.form-control:focus + .input-group-append > .input-group-text {
  border-color: #80bdff !important;
}
</style>

<script>
import axios from 'axios';

export default {
  props: {
    referer: String
  },
  data() {
    return {
      isSigningIn: false,
      input: {
        username: null,
        password: null
      },
      errors: {}
    };
  },
  methods: {
    signinFormOnSubmit() {
      this.isSigningIn = true;
      this.errors = {};

      axios({
        method: 'POST',
        url: '/api/auth/login',
        data: {
          email: this.input.email,
          password: this.input.password
        }
      })
      .then(response => {
        document.location = this.referer instanceof String ? this.referer : document.location.origin;
      })
      .catch(error => {
        if (error.response instanceof Object && error.response.data instanceof Object) {
          const errors = error.response.data.errors;

          if (errors instanceof Object) {
            this.errors = errors;
          }
        }
      })
      .finally(() => {
        this.isSigningIn = false;
      });
    }
  }
}
</script>
