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
      <div class="row">
        <div class="col-md-8">
          <div class="box box-solid d-flex flex-column">
            <div class="box-body">
              <div class="product__gallery">
                <div v-for="(gallery, i) in meta.galleries" :key="i" class="product__gallery__list">
                  <img class="product__gallery__image" :src="gallery.src">
                  <button class="product__gallery__remove__button" @click="(i => () => {removeProductGallery(i)})(i)">
                    <i class="feather icon-trash"></i>
                  </button>
                </div>
                <div class="product__gallery__list">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="galleryFileInput" form="updateForm" @change="galleryFileInputOnChange">
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
              <form id="updateForm" enctype="multipart/form-data" @submit.prevent="updateFormOnSubmit">
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
                <button class="btn btn-primary" form="updateForm" :disabled="isUpdating">
                  <i v-if="isUpdating" class="feather icon-loader"></i>
                  <span class="text">{{isUpdating ? 'Memperbarui' : 'Perbarui'}}</span>
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
                <input class="custom-file-input" id="imageInput" type="file" form="updateForm" name="image" ref="imageInput" @change="imageInputOnChange">
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
                <input class="form-control" id="slugInput" type="text" form="updateForm" name="slug" spellcheck="false" autocomplete="off" v-model="input.slug">
                <div v-for="(error, i) in errors.slug" :key="i" class="help-block">{{error}}</div>
              </div>
              <div :class="`form-group${errors.quantity instanceof Array ? ' has-error' : ''}`">
                <label for="jumlahInput">Jumlah</label>
                <input class="form-control" id="jumlahInput" type="number" form="updateForm" name="quantity" v-model="input.quantity">
                <div v-for="(error, i) in errors.quantity" :key="i" class="help-block">{{error}}</div>
              </div>
              <div :class="`form-group${errors.price instanceof Array ? ' has-error' : ''}`">
                <label for="hargaInput">Harga</label>
                <input class="form-control" id="hargaInput" type="number" form="updateForm" name="price" v-model="input.price">
                <div v-for="(error, i) in errors.price" :key="i" class="help-block">{{error}}</div>
              </div>
            </div>
          </div>
          <div class="box box-solid d-flex flex-column">
            <div class="box-header">
              <h1 class="box-title">Kategori</h1>
            </div>
            <div class="box-body" style="max-height: 200px;">
              <category-checkbox v-for="(category, i) in categories" :key="i" :category="category" :checkedCategories="meta.checkedCategories" ref="categoryCheckbox" />
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

let $productGallery, checkedCategoriesCount;

export default {
  components: {
    CategoryCheckbox
  },
  layout: Layout,
  props: {
    productId: Number
  },
  data() {
    return {
      isGettingDetail: true,
      isUpdating: false,
      errors: {},
      data: {},
      input: {
        name: null,
        description: null,
        slug: null,
        price: null,
        quantity: null,
        galleries: {
          insert: [],
          udpate: [],
          delete: [],
        },
        categories: {
          insert: [],
          update: [],
          delete: [],
        },
      },
      meta: {
        image: null,
        galleries: [],
        checkedCategories: {},
        galleriesCount: 0,
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
    removeProductGallery(i) {
      this.meta.galleries.splice(i, 1);

      if (i < this.galleriesCount - 1) {
        const gallery = this.input.galleries.update.splice(i, 1);

        if (this.input.galleries.insert.length > 0) {
          gallery.image = true;
        }
        else {
          this.input.galleries.delete.push(gallery.gallery_id);
        }
      }
    },
    galleryFileInputOnChange(event) {
      const input = event.target;

      Array.prototype.forEach.call(event.target.files, file => {
        const reader = new FileReader();

        reader.onload = event => {
          this.meta.galleries.push({
            src: event.currentTarget.result
          });

          setTimeout(() => {
            input.removeEventListener('change', this.galleryFileInputOnChange);
            input.removeAttribute('id');

            console.log(this.input.galleries.update);

            const command = this.input.galleries.update.length < this.galleriesCount ? 'update' : 'insert';
            const i = command === 'update' ? this.input.galleries.update.length : this.input.galleries.insert.length;
            console.log(`galleries[${command}][${i}]`);

            input.name = `galleries[${command}][${i}]`;

            input.setAttribute('form', 'updateForm');

            const $input = $('<input class="custom-file-input" id="galleryFileInput" type="file">');

            $input[0].addEventListener('change', this.galleryFileInputOnChange);

            $('.product__gallery').children().eq(this.meta.galleries.length - 1).append(input);
            $('.product__gallery').children().eq(this.meta.galleries.length).children().append($input);
          });
        }

        reader.readAsDataURL(file);
      });
    },
    removeMetaImageOnClick() {
      this.$refs.imageInput.value = '';
      this.meta.image = null;
    },
    updateFormOnSubmit(event) {
      this.isUpdating = true;
      this.errors = {};

      const formData = new FormData(event.target);

      formData.append('_method', 'PATCH');
      formData.append('product_id', this.productId);
      formData.set('description', CKEDITOR.instances.descriptionTextarea.getData());

      if (this.input.categories.insert.length > 0) {
        this.input.categories.insert.forEach(category_id => {
          formData.set('categories[insert][]', category_id);
        });
      }

      if (this.input.categories.update.length > 0) {
        this.input.categories.update.forEach((category, i) => {
          formData.set(`categories[update][${i}][product_2_category_id]`, category.product_2_category_id);
          formData.set(`categories[update][${i}][category_id]`, category.category_id);
        });
      }

      if (this.input.categories.delete.length > 0) {
        this.input.categories.delete.forEach(product_2_category_id => {
          formData.set('categories[delete][]', product_2_category_id);
        });
      }

      if (this.data.image === this.meta.image) {
        formData.delete('image');
      }

      axios({
        method: 'POST',
        url: '/api/admin/product',
        data: formData
      })
      .then(() => {
        // this.$inertia.visit('/admin/product');
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
        this.isUpdating = false;
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

        axios.get(`/api/admin/product/detail/${this.productId}`).then(response => {
          if (response.data instanceof Object) {
            const data = response.data.data;

            checkedCategoriesCount = data.categories.length;

            if (data instanceof Object) {
              this.input.name = data.name;
              this.input.slug = data.slug;
              this.input.description = data.description;
              this.input.image = null;
              this.input.quantity = data.quantity;
              this.input.price = data.price;
              this.input.categories.update = data.categories;

              this.meta.image = data.image;
              this.data.image = data.image;

              data.categories.forEach(category => {
                this.meta.checkedCategories[category.category_id] = category.product_2_category_id;
              });

              data.galleries.forEach(gallery => {
                // this.input.galleries.update.push({
                //   gallery_id: gallery.gallery_id,
                // });
                this.meta.galleries.push({
                  src: gallery.image,
                });
              });

              this.galleriesCount = data.galleries.length;

              axios.get('/api/category').then(response => {
                if (response.data instanceof Object) {
                  const data = response.data.data;

                  if (data instanceof Object) {
                    this.categories = data;

                    setTimeout(() => {
                      Array.prototype.forEach.call(document.forms['updateForm'].elements['categories[]'], category => {
                        category.addEventListener('change', event => {
                          const category_id = parseInt(event.target.value);

                          if (event.target.checked) {
                            if (this.input.categories.update.length < checkedCategoriesCount) {
                              const product_2_category_id = this.input.categories.delete.pop();

                              this.input.categories.update.push({
                                product_2_category_id,
                                category_id,
                              });
                            }
                            else {
                              this.input.categories.insert.push(category_id);
                            }
                          }
                          else {
                            const i = this.input.categories.insert.indexOf(category_id);
                            const j = this.input.categories.update.findIndex(category => {
                              return category.category_id === category_id;
                            });

                            if (i > -1) {
                              this.input.categories.insert.splice(i);
                            }
                            else if (j > -1) {
                              const category = this.input.categories.update.splice(j, 1)[0];

                              if (this.input.categories.insert.length > 0) {
                                category.category_id = this.input.categories.insert.shift();
                                this.input.categories.update[checkedCategoriesCount - 1] = category;
                              }
                              else {
                                this.input.categories.delete.push(category.product_2_category_id);
                              }
                            }
                          }
                        });
                      });
                    });
                  }
                }
              });

              CKEDITOR.replace('descriptionTextarea');
            }
          }
        });
      });
    });
  }
}
</script>
