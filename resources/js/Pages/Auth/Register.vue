<template>
  <div class="register-page">
    <div class="container h-100">
      <div class="row justify-content-center align-content-center h-100">
        <div class="col-auto">
          <h1 class="malangpedia-text">Malang<strong>Pedia</strong></h1>
          <div class="card register-card">
            <div class="card-body register-card-body">
              <h4 class="register-box-msg">Daftar</h4>
              <form @submit.prevent="signinFormOnSubmit">
                <div class="form-group mb-4">
                  <input v-bind:class="`form-control${errors.name instanceof Array ? ' is-invalid' : ''}`" type="name" name="name" spellcheck="false" autocomplete="off" placeholder="Nama" v-model="input.name">
                  <small v-for="(error, i) in errors.name" v-bind:key="i" class="form-text text-danger">{{error}}</small>
                </div>
                <div class="form-group mb-4">
                  <input v-bind:class="`form-control${errors.email instanceof Array ? ' is-invalid' : ''}`" type="email" name="email" spellcheck="false" autocomplete="off" placeholder="Email" v-model="input.email">
                  <small v-for="(error, i) in errors.email" v-bind:key="i" class="form-text text-danger">{{error}}</small>
                </div>
                <div class="form-group mb-4">
                  <div class="d-flex">
                    <div class="custom-control custom-radio">
                      <input type="radio" id="maleRadioInput" name="gender" class="custom-control-input" value="1" v-model="input.gender">
                      <label class="custom-control-label" for="maleRadioInput">Laki-laki</label>
                    </div>
                    <div class="custom-control custom-radio ml-3">
                      <input type="radio" id="femaleRadioInput" name="gender" class="custom-control-input" value="2" v-model="input.gender">
                      <label class="custom-control-label" for="femaleRadioInput">Perempuan</label>
                    </div>
                  </div>
                  <small v-for="(error, i) in errors.gender" v-bind:key="i" class="form-text text-danger">{{error}}</small>
                </div>
                <div class="form-group mb-4">
                  <input v-bind:class="`form-control${errors.password instanceof Array ? ' is-invalid' : ''}`" type="password" name="password" placeholder="Password" v-model="input.password">
                  <small v-for="(error, i) in errors.password" v-bind:key="i" class="form-text text-danger">{{error}}</small>
                </div>
                <div class="form-group mb-4">
                  <input class="form-control" type="password" name="password_confirmation" placeholder="Konfirmasi Password" v-model="input.password_confirmation">
                </div>
                <div class="d-flex justify-content-end">
                  <button class="btn btn-primary w-100" v-bind:disabled="isRegistering">
                    <i v-if="isRegistering" class="feather icon-loader"></i>
                    <span class="text">{{isRegistering ? 'Mendaftarkan' : 'Daftar'}}</span>
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

.register-page {
  height: 100%;
}

.register-card {
  width: 360px;
}

.register-box-msg {
  color: #303030;
  font-size: 16 px;
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
      isRegistering: false,
      input: {
        name: 'Aziz Firmansyah Ramawandani',
        email: 'aframawandani@gmail.com',
        gender: 1,
        password: 'test123',
        password_confirmation: 'test123'
      },
      errors: {}
    };
  },
  methods: {
    signinFormOnSubmit() {
      this.isRegistering = true;
      this.errors = {};

      axios({
        method: 'POST',
        url: '/api/auth/register',
        data: {
          name: this.input.name,
          email: this.input.email,
          gender: this.input.gender,
          password: this.input.password,
          password_confirmation: this.input.password_confirmation
        }
      })
      .then(response => {
        console.log(response.data);
//        document.location = this.referer instanceof String ? this.referer : document.location.origin;
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
        this.isRegistering = false;
      });
    }
  }
}
</script>
