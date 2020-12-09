<template>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="feather icon-box"></i> Perbarui Produk</h1>
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
          <span class="text">Perbarui</span>
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
                  <span class="text">{{isInserting ? 'Menambah' : 'Perbarui'}}</span>
                </button>
              </div>
            </div>
          </div>
          <div class="box box-solid d-flex flex-column">
            <div class="box-header">
              <h1 class="box-title">Gambar</h1>
            </div>
            <div class="box-body">
              <div v-if="isGettingDetail" class="d-flex justify-content-center">
                <i class="feather icon-loader"></i>
              </div>
              <div v-if="!isGettingDetail" v-bind:class="`form-group mb-0${errors.image instanceof Array ? ' has-error' : ''}`">
                <input class="custom-file-input" id="imageInput" type="file" form="insertForm" name="image" v-bind:disabled="isInserting" ref="imageInput" @change="imageInputOnChange">
                <div v-if="typeof meta.image === 'string'" class="d-flex">
                  <div class="d-flex">
                    <label class="custom-file-label font-normal cursor-pointer text-primary mb-0" for="imageInput">Ganti</label>
                  </div>
                  <a class="d-flex text-danger" href="javascript:void(0)" style="margin-left: 10px;" @click="removeMetaImageOnClick">
                    <span class="text">Hapus</span>
                  </a>
                </div>
                <div v-if="meta.image === null" class="d-flex custom-file">
                  <label class="custom-file-label font-normal cursor-pointer text-primary mb-0" for="imageInput">Upload</label>
                </div>
                <div v-for="(error, i) in errors.image" v-bind:key="i" class="help-block">{{error}}</div>
                <div v-if="typeof meta.image === 'string'" style="border: 1px solid #d2d6de; margin-top: 4px;">
                  <img v-bind:src="meta.image">
                </div>
              </div>
            </div>
          </div>
          <div class="box box-solid d-flex flex-column">
            <div class="box-body">
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
      isGettingDetail: true,
      isInserting: false,
      errors: {},
      data: {},
      input: {
        name: null,
        description: null,
        slug: null,
        price: null,
        quantity: null
      },
      meta: {
        image: null
      },
      categories: []
    };
  },
  methods: {
    imageInputOnChange(event) {
      Array.prototype.forEach.call(event.target.files, file => {
        const reader = new FileReader();

        reader.onload = event => {
          this.meta.image = event.currentTarget.result;
        }

        reader.readAsDataURL(file);
      });
    },
    removeMetaImageOnClick() {
      this.$refs.imageInput.value = '';
      this.meta.image = null;
    },
    insertFormOnSubmit(event) {
      this.isInserting = true;
      this.errors = {};

      const formData = new FormData(event.target);

      formData.append('_method', 'PATCH');
      formData.append('product_id', this.data.product_id);
      formData.set('description', CKEDITOR.instances.descriptionTextarea.getData());

      if (this.data.image === this.meta.image) {
        formData.delete('image');
      }

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
  },
  mounted() {
    scripts.include('/assets/admin/js/select2.min.js').then(() => {
      scripts.include('/assets/admin/bower_components/ckeditor/ckeditor.js').then(() => {
        const matches = document.location.pathname.match(/\/admin\/product\/update\/([0-9]+)/);

        axios
        .get(`/api/admin/product/detail/${matches[1]}`)
        .then(response => {
          if (response.data instanceof Object) {
            const data = response.data.data;

            if (data instanceof Object) {
              this.data = data;

              data.price = Number.parseFloat(data.price).toString();

              for (let i in this.input) {
                if (typeof data[i] !== 'undefined') {
                  this.input[i] = data[i];
                }
              }

              CKEDITOR.replace('descriptionTextarea');

              for (let i in this.meta) {
                if (typeof data[i] !== 'undefined') {
                  this.meta[i] = data[i];
                }
              }
            }
          }
        })
        .finally(() => {
          this.isGettingDetail = false;
        });

        axios.get('/api/category').then(response => {
          if (response.data instanceof Object) {
            const data = response.data.data;

            if (data instanceof Object) {
              this.categories = data;
            }
          }
        });

        $(this.$refs.nameInput).on('input', event => {
          this.input.slug = slugify(event.currentTarget.value.toLowerCase());
        });
      });
    });
  }
}
</script>
