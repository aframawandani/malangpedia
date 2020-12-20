<template>
  <div>
    <div class="breadcrumb-option">
      <div class="container">
         <div class="row">
          <div class="col-lg-12">
            <div v-if="isLoading" class="loading-value" style="height: 16px;"></div>
            <div v-if="!isLoading" class="breadcrumb__links">
              <inertia-link href="/"><i class="fa fa-home"></i> Home</inertia-link>
              <inertia-link v-for="(category, i) in data.categories" :key="i" :href="category.url">{{category.name}}</inertia-link>
              <span>{{isLoading ? '?': data.name}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="product-details spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="product__details__pic">
              <div class="product__details__slider__content">
                <div class="product__details__pic__slider owl-carousel">
                  <img v-if="!isLoading && typeof data.image === 'string'" data-hash="product-1" class="product__big__img" v-bind:src="data.image" alt="">
                </div>
              </div>
              <div class="product__details__pic__left product__thumb nice-scroll">
                <a class="pt active" href="#product-1">
                  <img v-if="!isLoading && typeof data.image === 'string'" v-bind:src="data.image" alt="">
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="product__details__text">
              <div v-if="isLoading" class="loading-value" style="height: 20px; margin-bottom: 12px;"></div>
              <h3 v-if="!isLoading">{{data.name}}</h3>
              <div class="product__details__price">
                <div v-if="isLoading" class="loading-value" style="height: 30px;"></div>
                <div v-if="!isLoading">Rp {{Number.parseFloat(data.price).toLocaleString('id-ID')}}</div>
              </div>
              <div v-if="isLoading" class="loading-value" style="height: 62px; margin-bottom: 25px;"></div>
              <div v-if="!isLoading" class="product__details__button">
                <div class="quantity">
                  <span>Jumlah:</span>
                  <div class="pro-qty">
                    <input id="quantityInput" type="text" value="1">
                  </div>
                </div>
                <a href="javascript:void(0)" class="cart-btn" @click="shoppingCartProductInsertButtonOnClick">Tambah ke Keranjang</a>
              </div>
              <div class="product__details__widget">
                <ul>
                  <li>
                    <div v-if="isLoading" class="loading-value" style="height: 14px;"></div>
                    <span v-if="!isLoading">Tersedia:</span>
                    <span v-if="!isLoading">{{data.quantity}}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="product__details__tab">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="description-tab-pane" role="tabpanel">
                  <h6>Description</h6>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 40%;"></div>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 50%;"></div>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 30%;"></div>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 20%;"></div>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 60%;"></div>
                  <p v-if="!isLoading" v-html="data.description"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
import Layout from '@/Shared/Layout';
import store from '@/store';

function product_thumbs (num) {
  var thumbs = document.querySelectorAll('.product__thumb a');
  thumbs.forEach(function (e) {
    e.classList.remove("active");
    if(e.hash.split("-")[1] == num) {
      e.classList.add("active");
    }
  })
}

export default {
  components: {},
  layout: Layout,
  data() {
    return {
      isLoading: true,
      data: {}
    }
  },
  mounted() {
    $('.product__thumb .pt').on('click', function(){
      var imgurl = $(this).data('imgbigurl');
      var bigImg = $('.product__big__img').attr('src');
      if(imgurl != bigImg) {
        $('.product__big__img').attr({src: imgurl});
      }
    });

    $(".product__details__pic__slider").owlCarousel({
      loop: false,
      margin: 0,
      items: 1,
      dots: false,
      nav: true,
      navText: ["<i class='arrow_carrot-left'></i>","<i class='arrow_carrot-right'></i>"],
      smartSpeed: 1200,
      autoHeight: false,
      autoplay: false,
      mouseDrag: false,
      startPosition: 'URLHash'
    }).on('changed.owl.carousel', function(event) {
      var indexNum = event.item.index + 1;
      product_thumbs(indexNum);
    });

    axios
    .get('/api'+document.location.pathname)
    .then(response => {
      const data = response.data.data;

      if (data instanceof Object) {
        this.data = data;
      }
    })
    .finally(() => {
      this.isLoading = false;
    });
  },
  methods: {
    shoppingCartProductInsertButtonOnClick() {
      this.$store.commit('insertShoppingCartProduct', {
        product_id: this.data.product_id,
        quantity: Number.parseInt($('#quantityInput').val())
      });
    }
  }
}
</script>
