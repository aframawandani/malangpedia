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
      <div class="row">
        <div class="col-md-8">
          <div class="box box-solid d-flex flex-column">
            <div class="box-body">
              <div class="product__gallery">
                <div v-for="(gallery, i) in meta.gallery" :key="i" class="product__gallery__list">
                  <img class="product__gallery__image" :src="gallery.src">
                  <button class="product__gallery__remove__button" @click="(i => () => {removeProdyctGallery(i)})(i)">
                    <i class="feather icon-trash"></i>
                  </button>
                </div>
                <div class="product__gallery__list">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="galleryFileInput" form="insertForm" @change="galleryFileInputOnChange">
                    <label class="custom-file-label mb-0 product__gallery__input__label" for="galleryFileInput">
                      <i class="feather icon-plus"></i>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box box-solid d-flex flex-column">
            <div class="box-body">
              <form id="insertForm" enctype="multipart/form-data" @submit.prevent="insertFormOnSubmit">
                <div :class="`form-group${errors.name instanceof Array ? ' has-error' : ''}`">
                  <input class="form-control" type="text" name="name" spellcheck="false" autocomplete="off" placeholder="Nama Produk" ref="nameInput" v-model="input.name">
                  <div v-for="(error, i) in errors.name" :key="i" class="help-block">{{error}}</div>
                </div>
                <div>
                  <textarea class="form-control" id="descriptionTextarea" name="description" spellcheck="false" autocomplete="off" rows="8" v-model="input.description"></textarea>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box box-solid d-flex flex-column">
            <div class="box-body">
              <div>
                <button class="btn btn-primary" form="insertForm" :disabled="isInserting">
                  <i v-if="isInserting" class="feather icon-loader"></i>
                  <span class="text">{{isInserting ? 'Menambah' : 'Tambah'}}</span>
                </button>
              </div>
            </div>
          </div>
          <div class="box box-solid d-flex flex-column">
            <div class="box-header">
              <h1 class="box-title">Gambar</h1>
            </div>
            <div class="box-body">
              <div class="form-group mb-0 overflow-hidden">
                <input class="custom-file-input" id="imageInput" type="file" form="insertForm" name="image" ref="imageInput" @change="imageInputOnChange">
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
                <div v-for="(error, i) in errors.image" :key="i" class="help-block">{{error}}</div>
                <div v-if="typeof meta.image === 'string'" style="margin-top: 4px;">
                  <img class="product__image" :src="meta.image">
                </div>
              </div>
            </div>
          </div>
          <div class="box box-solid d-flex flex-column">
            <div class="box-body">
              <div :class="`form-group${errors.slug instanceof Array ? ' has-error' : ''}`">
                <label>Slug</label>
                <input class="form-control" id="slugInput" type="text" form="insertForm" name="slug" spellcheck="false" autocomplete="off" v-model="input.slug">
                <div v-for="(error, i) in errors.slug" :key="i" class="help-block">{{error}}</div>
              </div>
              <div :class="`form-group${errors.quantity instanceof Array ? ' has-error' : ''}`">
                <label>Jumlah</label>
                <input class="form-control" id="hargaInput" type="number" form="insertForm" name="quantity" v-model="input.quantity">
                <div v-for="(error, i) in errors.quantity" :key="i" class="help-block">{{error}}</div>
              </div>
              <div :class="`form-group${errors.price instanceof Array ? ' has-error' : ''}`">
                <label>Harga</label>
                <input class="form-control" id="hargaInput" type="number" form="insertForm" name="price" v-model="input.price">
                <div v-for="(error, i) in errors.price" :key="i" class="help-block">{{error}}</div>
              </div>
            </div>
          </div>
          <div class="box box-solid d-flex flex-column">
            <div class="box-header">
              <h1 class="box-title">Kategori</h1>
            </div>
            <div class="box-body" style="max-height: 200px;">
              <category-checkbox v-for="(category, i) in categories" :key="i" form="insertForm" :category="category" :checkedCategories="meta.checkedCategories" />
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style>
@import '/assets/admin/css/select2.min.css';

.product__image {
  height: auto;
  width: 100%;
}
</style>

<script>
import axios from 'axios';
import slugify from 'slugify';
import scripts from '@/scripts';
import Layout from '@/Shared/Admin/Layout';
import CategoryCheckbox from './Components/CategoryCheckbox';

let $productGallery;

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
        quantity: null,
        categories: [],
        gallery: [],
      },
      meta: {
        image: null,
        gallery: [],
        checkedCategories: {}
      },
      categories: [],
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
    removeProdyctGallery(i) {
      this.meta.gallery.splice(i, 1);
    },
    galleryFileInputOnChange(event) {
      const input = event.target;

      Array.prototype.forEach.call(event.target.files, file => {
        const reader = new FileReader();

        reader.onload = event => {
          this.meta.gallery.push({
            src: event.currentTarget.result
          });

          setTimeout(() => {
            input.removeEventListener('change', this.galleryFileInputOnChange);
            input.removeAttribute('id');

            input.name = 'gallery[]';

            input.setAttribute('form', 'insertForm');

            const $input = $('<input class="custom-file-input" id="galleryFileInput" type="file">');

            $input[0].addEventListener('change', this.galleryFileInputOnChange);

            $('.product__gallery').children().eq(this.meta.gallery.length - 1).append(input);
            $('.product__gallery').children().eq(this.meta.gallery.length).children().append($input);
          });
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

      formData.append('_method', 'PUT');

      Array.prototype.filter.call(document.forms['insertForm'].elements['categories[]'], input => input.checked).map(input => input.value).forEach(category_id => {
        formData.append('category_ids[]', category_id);
      });

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
        $productGallery = $('.product_gallery');

        $(this.$refs.nameInput).on('input', event => {
          this.input.slug = slugify(event.currentTarget.value.toLowerCase());
        });

        CKEDITOR.replace('descriptionTextarea');

        axios.get('/api/category').then(response => {
          if (response.data instanceof Object) {
            const data = response.data.data;

            if (data instanceof Object) {
              this.categories = data;
            }
          }
        });
      });
    });
  }
}
</script>
