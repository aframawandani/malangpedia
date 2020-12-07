<template>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="feather icon-box"></i> Tambah Produk</h1>
      <ol class="breadcrumb">
        <li>
          <inertia-link href="/admin">
            <span class="text">Beranda</span>
          </inertia-link>
        </li>
        <li>
          <inertia-link href="/admin/product">
            <span class="text">Produk</span>
          </inertia-link>
        </li>
        <li>
          <span class="text">Tambah</span>
        </li>
      </ol>
    </section>
    <section class="content">
      <div class="row h-100">
        <div class="col-md-8 h-100">
          <div class="box box-solid d-flex flex-column">
            <div class="box-body">
              <form id="insertForm" @submit.prevent="insertFormOnSubmit">
                <div v-bind:class="`form-group${errors.name instanceof Array ? ' has-error' : ''}`">
                  <input class="form-control" type="text" name="name" v-bind:disabled="isInserting" spellcheck="false" autocomplete="off" placeholder="Nama Produk" ref="nameInput" v-model="input.name">
                  <div v-for="(error, i) in errors.name" v-bind:key="i" class="help-block">{{error}}</div>
                </div>
                <div>
                  <textarea class="form-control" id="descriptionTextarea" name="description" v-bind:disabled="isInserting" spellcheck="false" autocomplete="off" rows="8" v-model="input.description"></textarea>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4 h-100">
          <div class="box box-solid d-flex flex-column">
            <div class="box-body">
              <div>
                <button class="btn btn-primary" form="insertForm" v-bind:disabled="isInserting">
                  <i v-if="isInserting" class="feather icon-loader"></i>
                  <span class="text">{{isInserting ? 'Menambah' : 'Tambah'}}</span>
                </button>
              </div>
            </div>
          </div>
          <div class="box box-solid d-flex flex-column">
            <div class="box-body">
              <div v-bind:class="`form-group${errors.image instanceof Array ? ' has-error' : ''}`">
                <label>Gambar</label>
                <input class="form-control" id="imageInput" type="file" form="insertForm" name="image" v-bind:disabled="isInserting">
                <div v-for="(error, i) in errors.image" v-bind:key="i" class="help-block">{{error}}</div>
              </div>
              <div v-bind:class="`form-group${errors.slug instanceof Array ? ' has-error' : ''}`">
                <label>Slug</label>
                <input class="form-control" id="slugInput" type="text" form="insertForm" name="slug" v-bind:disabled="isInserting" spellcheck="false" autocomplete="off" v-model="input.slug">
                <div v-for="(error, i) in errors.slug" v-bind:key="i" class="help-block">{{error}}</div>
              </div>
              <div v-bind:class="`form-group${errors.quantity instanceof Array ? ' has-error' : ''}`">
                <label>Jumlah</label>
                <input class="form-control" id="hargaInput" type="number" form="insertForm" name="quantity" v-bind:disabled="isInserting" v-model="input.quantity">
                <div v-for="(error, i) in errors.quantity" v-bind:key="i" class="help-block">{{error}}</div>
              </div>
              <div v-bind:class="`form-group${errors.price instanceof Array ? ' has-error' : ''}`">
                <label>Harga</label>
                <input class="form-control" id="hargaInput" type="number" form="insertForm" name="price" v-bind:disabled="isInserting" v-model="input.price">
                <div v-for="(error, i) in errors.price" v-bind:key="i" class="help-block">{{error}}</div>
              </div>
            </div>
          </div>
          <div class="box box-solid d-flex flex-column">
            <div class="box-header">
              <h1 class="box-title">Kategori</h1>
            </div>
            <div class="box-body" style="max-height: 200px;">
              <category-checkbox v-for="(category, i) in categories" v-bind:key="i" v-bind:category="category" />
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style>
@import '/assets/admin/css/select2.min.css';
</style>

<script>
import axios from 'axios';
import slugify from 'slugify';
import scripts from '@/scripts';
import Layout from '@/Shared/Admin/Layout';
import CategoryCheckbox from './Components/CategoryCheckbox';

export default {
  components: {
    CategoryCheckbox
  },
  layout: Layout,
  data() {
    return {
      isInserting: false,
      errors: {},
      input: {
        name: null,
        description: null,
        image: null,
        slug: null,
        price: null,
        quantity: null
      },
      categories: []
    };
  },
  mounted() {
    scripts.include('/assets/admin/js/select2.min.js').then(() => {
      scripts.include('/assets/admin/bower_components/ckeditor/ckeditor.js').then(() => {
        axios.get('/api/category').then(response => {
          if (response.data instanceof Object) {
            const data = response.data.data;

            if (data instanceof Object) {
              this.categories = data;
            }
          }
        });

        $(this.$refs.nameInput).on('input', event => {
          this.input.slug = slugify(event.currentTarget.value);
        });
        CKEDITOR.replace('descriptionTextarea');
      });
    });
  },
  methods: {
    insertFormOnSubmit(event) {
      this.isInserting = true;
      this.errors = {};

      const formData = new FormData(event.target);

      formData.append('_method', 'PUT');
      formData.set('description', CKEDITOR.instances.descriptionTextarea.getData());

      axios({
        method: 'POST',
        url: '/api/admin/product',
        data: formData
      })
      .then(response => {
        this.$inertia.visit('/admin/product');
      })
      .catch(error => {
        if (error.response.data instanceof Object)
        {
          const errors = error.response.data.errors;

          if (errors instanceof Object)
          {
            this.errors = errors;
          }
        }
      })
      .finally(() => {
        this.isInserting = false;
      });
    }
  }
}
</script>
