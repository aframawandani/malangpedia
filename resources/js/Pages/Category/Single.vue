<template>
  <div class="breadcrumb-option">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div v-if="isLoading && !isError" class="loading-value" style="height: 16px; width: 240px;"></div>
          <div v-if="!isLoading && !isError" class="breadcrumb__links">
            <inertia-link href="/"><i class="fa fa-home"></i> Home</inertia-link>
            <inertia-link v-for="(parent_category, i) in meta.parent_categories" :key="i" :href="parent_category.url">{{parent_category.name}}</inertia-link>
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
            <div v-if="isGettingProducts" class="row">
              <div v-for="i in 12" :key="i" class="col-lg-3 col-md-4">
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
            <div v-if="!isGettingProducts" class="row">
              <div v-for="(product, i) in data" :key="i" class="col-lg-3 col-md-4">
                <inertia-link class="product__item" :href="product.url">
                  <div class="product__item__pic set-bg">
                    <img :src="typeof product.image === 'string' ? `/assets/images/products/${product.image}.webp` : '/assets/images/no-product-image.svg'">
                    <div class="label new">New</div>
                  </div>
                  <div class="product__item__text">
                    <h6>{{product.name}}</h6>
                    <div class="product__price">Rp {{product.price.toLocaleString('id-ID')}}</div>
                  </div>
                </inertia-link>
              </div>
              <div v-if="data.length === 0" class="col-lg-12"></div>
              <div v-if="data.length > 0" class="col-lg-12 d-flex justify-content-center">
                <div class="pagination__option">
                  <a v-if="typeof links[0].url === 'string'" :href="links[0].url" @click.prevent="getProducts(currentPage - 1)">
                    <i class="feather icon-chevron-left"></i>
                  </a>
                  <a v-for="(link, i) in links.slice().splice(1, links.length - 2)" :key="i" :class="link.active ? 'active' : null" :href="link.url" @click.prevent="((page) => () => {getProducts(parseInt(page));})(parseInt(link.label))">{{link.label}}</a>
                  <a v-if="typeof links[links.length - 1].url === 'string'" :href="links[links.length - 1].url" @click.prevent="getProducts(currentPage + 1)">
                    <i class="feather icon-chevron-right"></i>
                  </a>
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
  props: {
    page: Number
  },
  layout: Layout,
  data() {
    return {
      isLoading: true,
      isGettingProducts: true,
      isError: false,
      currentPage: this.page,
      data: [],
      links: [],
      meta: {}
    }
  },
  methods: {
    getProducts(page) {
      this.isGettingProducts = true;
      this.currentPage = page;

      axios
      .get(`/api/product${document.location.pathname}${typeof page === 'number' && page > 0 ? `?page=${page}`: ''}`)
      .then(response => {
        const {data, links, meta} = response.data;

        if (data instanceof Array) {
          this.data = data;
        }

        if (links instanceof Object) {
          this.links = links;
        }

        if (meta instanceof Object) {
          this.meta = meta;
        }
      })
      .catch(() => {
        this.isError = true;
      })
      .finally(() => {
        this.isGettingProducts = false;
        this.isLoading = false;
      });
    }    
  },
  mounted() {
    this.getProducts(this.page);
  }
}</script>
