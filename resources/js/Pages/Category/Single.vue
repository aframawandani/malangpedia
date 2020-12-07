<template>
  <div class="breadcrumb-option">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div v-if="isLoading && !isError" class="loading-value" style="height: 16px; width: 240px;"></div>
          <div v-if="!isLoading && !isError" class="breadcrumb__links">
            <inertia-link href="/"><i class="fa fa-home"></i> Home</inertia-link>
            <inertia-link v-for="(parent_category, i) in meta.parent_categories" v-bind:key="i" v-bind:href="parent_category.url">{{parent_category.name}}</inertia-link>
            <span class="text">{{meta.category.name}}</span>
          </div>
        </div>
      </div>
    </div>
    <section class="shop spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-3">
            <div class="shop__sidebar">
              <sidebar-categories />
            </div>
          </div>
          <div class="col-lg-9 col-md-9">
            <div v-if="isLoading" class="row">
              <div v-for="i in 12" v-bind:key="i" class="col-lg-3 col-md-4">
                <div class="product__item">
                  <div class="product__item__pic set-bg">
                    <div class="loading-value" style="padding-top: 100%;"></div>
                  </div>
                  <div class="product__item__text">
                    <div class="loading-value" style="height: 16px;"></div>
                    <div class="product__price">
                      <div class="loading-value" style="height: 16px; width: 75%;"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="!isLoading && !isError" class="row">
              <div v-for="(product, i) in data" v-bind:key="i" class="col-lg-3 col-md-4">
                <inertia-link class="product__item" v-bind:href="product.url">
                  <div class="product__item__pic set-bg">
                    <img v-bind:src="product.image" />
                    <div class="label new">New</div>
                  </div>
                  <div class="product__item__text">
                    <h6>{{product.name}}</h6>
                    <div class="product__price">Rp {{product.price.toLocaleString('id-ID')}}</div>
                  </div>
                </inertia-link>
              </div>
              <div class="col-lg-12 text-center">
                <div class="pagination__option">
                  <a href="#">1</a>
                  <a href="#">2</a>
                  <a href="#">3</a>
                  <a href="#"><i class="fa fa-angle-right"></i></a>
                </div>
              </div>
            </div>
            <div v-if="!isLoading && isError" class="row">
              <div class="col-12">
                <h6 class="coupon__link">Kategori tidak ditemukan</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from 'axios';
import Layout from '@/Shared/Layout';
import SidebarCategories from '@/Shared/SidebarCategories';

export default {
  components: {
    SidebarCategories
  },
  layout: Layout,
  data() {
    return {
      isLoading: true,
      isError: false,
      data: [],
      meta: {}
    }
  },
  mounted() {
    axios
    .get('/api/product'+document.location.pathname)
    .then(response => {
      const data = response.data.data;
      const meta = response.data.meta;

      if (data instanceof Array) {
        this.data = data;
      }

      if (meta instanceof Object) {
        this.meta = meta;
      }
    })
    .catch(() => {
      this.isError = true;
    })
    .finally(() => {
      this.isLoading = false;
    });
  }
}</script>
