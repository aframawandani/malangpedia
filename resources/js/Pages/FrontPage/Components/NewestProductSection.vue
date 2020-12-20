<template>
  <section class="product spad">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="section-title">
            <h4>Produk Terbaru</h4>
          </div>
        </div>
      </div>
      <div class="row property__gallery">
        <div v-for="(product, i) in data" v-bind:key="i" class="col-lg-2 col-md-3 col-sm-4 col-xs-2">
          <inertia-link class="product__item" v-bind:href="product.url">
            <div class="product__item__pic set-bg">
              <img :src="typeof product.image === 'string' ? `/assets/images/products/${product.image}.webp` : '/assets/images/no-product-image.svg'">
              <div v-if="typeof product.new === 'boolean' && product.new" class="label new">BARU</div>
            </div>
            <div class="product__item__text">
              <h6>{{product.name}}</h6>
              <div v-if="typeof product.price === 'numeric' || typeof product.price === 'string'" class="product__price">Rp {{Number.parseFloat(product.price).toLocaleString('id-ID')}}</div>
            </div>
          </inertia-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
import VueLazyload from 'vue-lazyload';

Vue.use(VueLazyload);

export default {
  data() {
    return {
      data: []
    }
  },
  mounted() {
    axios
    .get('/api/newest-products')
    .then(response => {
      const data = response.data.data;

      if (data instanceof Object) {
        this.data = data;
      }
    })
    .catch(error => {});
  },
  components: {
    VueLazyload
  }
}
</script>