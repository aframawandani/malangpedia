<template>
  <div>
    <div v-for="(message, i) in messages" v-bind:key="i" v-bind:class="`${message.colorClasses} rounded text-sm mb-4 pl-4 pr-10 py-2 relative`" role="alert">
      <span class="inline-block leading-5">{{message.content}}</span>
      <button class="absolute top-0 p-2" style="right: 8px; top: 2px;" @click="removeMessage(i)">
        <x-icon size="16" />
      </button>
    </div>
    <form @submit.prevent="submit">
      <div>
        <label class="inline-block text-sm leading-5 text-gray-700 mb-1" for="nameInput">Nama</label>
        <input class="form-input block text-sm leading-5 w-full sm:text-sm sm:leading-5" id="nameInput" name="name" spellcheck="false" autocomplete="off">
        <span class="inline-block text-red-500 text-sm mt-1" v-for="(error, i) in errors.name instanceof Array ? errors.name : []" v-bind:key="i">{{error}}</span>
      </div>
      <div class="mt-4">
        <label class="inline-block text-sm leading-5 text-gray-700 mb-1" for="slugInput">Slug</label>
        <input class="form-input block text-sm leading-5 w-full sm:text-sm sm:leading-5" id="slugInput" name="slug" spellcheck="false" autocomplete="off">
        <span class="inline-block text-red-500 text-sm mt-1" v-for="(error, i) in errors.slug instanceof Array ? errors.name : []" v-bind:key="i">{{error}}</span>
      </div>
      <div class="mt-4">
        <label class="inline-block text-sm leading-5 text-gray-700 mb-1" for="descriptionTextarea">Deskripsi</label>
        <textarea class="form-input block text-sm leading-4 w-full sm:text-sm sm:leading-5" id="descriptionTextarea" name="description" spellcheck="false" rows="4"></textarea>
      </div>
      <div class="mt-4">
        <button class="bg-purple-500 hover:bg-purple-700 text-white text-sm p-3 rounded">{{isLoading ? 'Menambah...' : 'Tambah'}}</button>
      </div>
    </form>
  </div>
</template>

<script>
import cookie from '../../../cookies';
import axios from 'axios';

const messageTypes = {
  'info': true,
  'success': true,
  'warning': true,
  'danger': true
};

const colorClasses = {
  'info': 'bg-gray-200 text-gray-700',
  'success': 'bg-green-200 text-green-700',
  'warning': 'bg-yellow-200 text-yellow-700',
  'danger': 'bg-red-200 text-red-700'
}

export default {
  data() {
    return {
      isLoading: false,
      errors: {},
      messages: [
        {
          'content': 'Test 1',
          'type': 'danger',
          'colorClasses': colorClasses['danger']
        },
        {
          'content': 'Test 2',
          'type': 'success',
          'colorClasses': colorClasses['success']
        }
      ]
    }
  },
  props: [],
  methods: {
    submit(event) {
      const formData = new FormData(event.target);
      const data = {};

      this.isLoading = true;
      this.messages.length = 0;
      this.errors = {};

      formData.forEach((value, name) => {
        data[name] = value;
      });

      axios.put('/api/category', data, {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
      })
      .then(response => {
        if (response.status === 200) {
          getData();
        }
        else if (typeof response.json === 'function') {
          response.json().then(response => {
            this.errors = response.errors;
          });
        }
        else {

        }
      })
      .catch(error => {
        const data = error.response.data;

        if (data instanceof Object) {
          this.addMessage(data.message, 'danger');

          this.errors = data.errors;
        }
      })
      .finally(() => {
        this.isLoading = false;
      })
    },
    addMessage(content, type, i) {
      const message = {
        content: '',
        type: 'info',
        colorClasses: colorClasses['info']
      };

      if (typeof content === 'string') {
        message.content = content;
      }

      if (typeof type === 'string' && type in messageTypes) {
        message.type = type;
        message.colorClasses = colorClasses[type];
      }

      if (typeof i === 'number' && Number.isFinite(i)) {
        this.messages.splice(i, 0, message);
      }
      else {
        this.messages.push(message);
      }
    },
    removeMessage(i) {
      this.messages.splice(i, 1);
    },
    getColorClasses(type) {
      if (typeof type === 'string' && type in colorClasses) {
        return colorClasses[type];
      }

      return colorClasses['info'];
    }
}
}
</script>