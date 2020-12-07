<template>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="feather icon-tag"></i> Perbarui Kategori</h1>
      <ol class="breadcrumb">
        <li>
          <inertia-link href="/admin">
            <span class="text">Beranda</span>
          </inertia-link>
        </li>
        <li>
          <inertia-link href="/admin/category">
            <span class="text">Kategori</span>
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
          <div class="box box-solid d-flex flex-column mh-100">
            <div class="box-body">
              <form id="updateForm" @submit.prevent="updateFormOnSubmit">
                <div v-bind:class="`form-group${errors.name instanceof Array ? ' has-error' : ''}`">
                  <label for="namaInput">Nama</label>
                  <input class="form-control" type="text" name="name" v-bind:disabled="isGettingDetail || isUpdating" spellcheck="false" autocomplete="off" v-model="input.name">
                  <div v-for="(error, i) in (errors.name instanceof Array ? errors.name : [])" v-bind:key="i" class="help-block">{{error}}</div>
                </div>
                <div v-bind:class="`form-group${errors.slug instanceof Array ? ' has-error' : ''}`">
                  <label for="slugInput">Slug</label>
                  <input class="form-control" type="text" name="slug" v-bind:disabled="isGettingDetail || isUpdating" spellcheck="false" autocomplete="off" v-model="input.slug">
                  <div v-for="(error, i) in (errors.slug instanceof Array ? errors.slug : [])" v-bind:key="i" class="help-block">{{error}}</div>
                </div>
                <div class="form-group">
                  <label for="description">Deskripsi</label>
                  <textarea class="form-control" name="description" v-bind:disabled="isGettingDetail || isUpdating" rows="6" spellcheck="false" autocomplete="off" v-model="input.description"></textarea>
                  <div v-for="(error, i) in (errors.description instanceof Array ? errors.description : [])" v-bind:key="i" class="help-block">{{error}}</div>
                </div>
                <div v-bind:class="`form-group${errors.parent_category_id instanceof Array ? ' has-error' : ''}`">
                  <label>Kategori Induk</label>
                  <select id="parentCategoryIdSelect" name="parent_category_id" v-bind:disabled="isGettingDetail || isUpdating" style="width: 100%;">
                    <option v-if="typeof input.parent_category_id === 'number'" selected v-bind:value="input.parent_category_id">{{meta.parent_category_name}}</option>
                  </select>
                  <div v-for="(error, i) in (errors.parent_category_id instanceof Array ? errors.parent_category_id : [])" v-bind:key="i" class="help-block">{{error}}</div>
                </div>
                <div>
                  <button class="btn btn-primary" v-bind:disabled="isGettingDetail || isUpdating">
                    <i v-if="isUpdating" class="feather icon-loader"></i>
                    <span class="text">Perbarui</span>
                  </button>
                  <button class="btn btn-default" type="button" v-bind:disabled="isUpdating" @click="updateFormCancelButtonOnClick" style="margin-left: 10px;">
                    <span class="text">Batal</span>
                  </button>
                </div>
              </form>
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
import scripts from '@/scripts';
import Layout from '@/Shared/Admin/Layout';

export default {
  layout: Layout,
  data() {
    return {
      isGettingDetail: true,
      isUpdating: false,
      isInitialValue: true,
      errors: {},
      input: {
        _method: 'PATCH',
        category_id: null,
        name: null,
        slug: null,
        description: null,
        parent_category_id: null
      },
      meta: {
        parent_category_name: null
      }
    };
  },
  mounted() {
    scripts.include('/assets/js/select2.min.js').then(() => {
      const matches = document.location.pathname.match(/^\/admin\/category\/update\/([0-9]+)$/);
      const $parentCategoryIdSelect = $('#parentCategoryIdSelect');

      axios
      .get(`/api/admin/category/detail/${matches[1]}`)
      .then(response => {
        if (response.data instanceof Object) {
          const data = response.data.data;

          if (data instanceof Object) {
            this.input.category_id = data.category_id;
            this.input.name = data.name;
            this.input.slug = data.slug;
            this.input.description = data.description;
            this.input.parent_category_id = data.parent_category_id;
            this.meta.parent_category_name = data.parent_category_name;

            $parentCategoryIdSelect.select2({
              ajax:  {
                url: '/api/admin/category/options',
                processResults: data => {
                  data.results.unshift({id: '', text: '\xa0'});

                  return {
                    results: data.results
                  }
                }
              }
            })
            .change(event => {
              this.input.parent_category_id = event.target.value;
            });
          }
        }
      })
      .catch()
      .finally(() => {
        this.isGettingDetail = false;
      });

      let ajaxUrl = '/api/admin/category/options';

    });
  },
  methods: {
    updateFormOnSubmit(event) {
      this.isUpdating = true;

      axios({
        method: 'POST',
        url: '/api/admin/category',
        data: this.input
      })
      .then(response => {
        this.$inertia.visit('/admin/category');
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
    },
    updateFormCancelButtonOnClick() {
      history.back();
    }
  }
}
</script>
