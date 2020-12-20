<template>
  <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="feather icon-tag"></i> Tambah Kategori</h1>
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
          <span class="text">Tambah</span>
        </li>
      </ol>
    </section>
    <section class="content">
      <div class="row h-100">
        <div class="col-md-12 h-100">
          <div class="box box-solid d-flex flex-column mh-100">
            <div class="box-body">
              <form id="insertForm" @submit.prevent="insertFormOnSubmit">
                <div style="overflow: hidden;">
                  <div class="row">
                    <div class="col-md-6">
                      <div v-bind:class="`form-group${errors.name instanceof Array ? ' has-error' : ''}`" style="overflow: hidden;">
                        <label for="namaInput">Nama</label>
                        <input class="form-control" type="text" name="name" spellcheck="false" autocomplete="off" v-model="input.name">
                        <div v-for="(error, i) in (errors.name instanceof Array ? errors.name : [])" v-bind:key="i" class="help-block">{{error}}</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div v-bind:class="`form-group${errors.slug instanceof Array ? ' has-error' : ''}`" style="overflow: hidden;">
                        <label for="slugInput">Slug</label>
                        <input class="form-control" type="text" name="slug" spellcheck="false" autocomplete="off" v-model="input.slug">
                        <div v-for="(error, i) in (errors.slug instanceof Array ? errors.slug : [])" v-bind:key="i" class="help-block">{{error}}</div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div v-bind:class="`form-group${errors.description instanceof Array ? ' has-error' : ''}`" style="overflow: hidden;">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="6" spellcheck="false" autocomplete="off" v-model="input.description"></textarea>
                        <div v-for="(error, i) in (errors.description instanceof Array ? errors.description : [])" v-bind:key="i" class="help-block">{{error}}</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div v-bind:class="`form-group${errors.parent_category_id instanceof Array ? ' has-error' : ''}`">
                        <label>Kategori Induk</label>
                        <select id="parentCategoryIdSelect" name="parent_category_id" style="width: 100%;"></select>
                        <div v-for="(error, i) in (errors.parent_category_id instanceof Array ? errors.parent_category_id : [])" v-bind:key="i" class="help-block">{{error}}</div>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-end">
                    <button class="btn btn-primary">
                      <i v-if="isInserting" class="feather icon-loader"></i>
                      <span class="text">{{isInserting ? 'Menambah' : 'Tambah'}}</span>
                    </button>
                    <button class="btn btn-default" type="button" v-bind:disabled="isInserting" @click="insertFormCancelButtonOnClick" style="margin-left: 10px;">
                      <span class="text">Batal</span>
                    </button>
                  </div>
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
      isInserting: false,
      errors: {},
      input: {
        name: null,
        slug: null,
        description: null,
        parent_category_id: null
      }
    };
  },
  mounted() {
    scripts.include('/assets/admin/js/select2.min.js').then(() => {
      $('#parentCategoryIdSelect').select2({
        ajax: {
          url: '/api/admin/category/options',
          processResults: data => {
            data.results.unshift({id: '', text: '\xa0'});

            return {
              results: data.results
            }
          }
        }
      });
    });
  },
  methods: {
    insertFormOnSubmit(event) {
      this.isInserting = true;
      const data = {
        _method: 'PUT',
        ...this.input
      };

      formData.append('_method', 'put');

      axios({
        method: 'POST',
        url: '/api/admin/category',
        data
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
        this.isInserting = false;
      });
    },
    insertFormCancelButtonOnClick() {
      history.back();
    }
  }
}
</script>
