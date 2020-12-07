<template>
  <div>
    <div class="breadcrumb-option">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="breadcrumb__links">
              <inertia-link href="/"><i class="fa fa-home"></i> Home</inertia-link>
              <span>Keranjang Belanja</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="shop-cart spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="shop__cart__table">
              <table>
                <thead>
                  <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(shopping_cart_product, idx) in $store.state.shoppingCartProducts" v-bind:key="shopping_cart_product.product_id">
                    <td class="cart__product__item">
                      <img v-bind:src="shopping_cart_product.image" width="90" alt="">
                      <div class="cart__product__item__title">
                        <h6>{{shopping_cart_product.name}}</h6>
                        <div class="rating">
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                        </div>
                      </div>
                    </td>
                    <td class="cart__price">Rp {{shopping_cart_product.price.toLocaleString('id-ID')}}</td>
                    <td class="cart__quantity">
                      <div class="pro-qty">
                        <button class="qtybtn" @click="() => {$store.commit('decreaseQuantityShoppingCartProduct', {idx})}">
                          <i class="feather icon-minus"></i>
                        </button>
                        <input type="text" v-model="shopping_cart_product.quantity" @beforeinput="quantityInputOnBeforeInput" @change="event => {$store.commit('updateQuantityShoppingCartProduct', {idx, quantity: Number.parseInt(event.target.value)});}">
                        <button class="qtybtn" @click="() => {$store.commit('increaseQuantityShoppingCartProduct', {idx})}">
                          <i class="feather icon-plus"></i>
                        </button>
                      </div>
                    </td>
                    <td class="cart__total">Rp {{(shopping_cart_product.price * shopping_cart_product.quantity).toLocaleString('id-ID')}}</td>
                    <td class="cart__close">
                      <button class="btn btn-light btn-icon" @click="() => {$store.commit('removeShoppingCartProduct', {idx})}">
                        <i class="feather icon-x"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="cart__btn update__btn">
              <button type="button" @click="refresh">Refresh</button>
            </div>
          </div>
          <div class="col-lg-4 offset-lg-2">
            <div class="cart__total__procced">
              <h6>Total Keranjang Belanja</h6>
              <ul>
                <li>Total <span>Rp {{$store.state.shoppingCartProducts.reduce((acc, cur) => acc + cur.quantity * cur.price, 0).toLocaleString('id-ID')}}</span></li>
              </ul>
              <inertia-link href="/checkout" class="primary-btn">Lanjutkan ke Pembayaran</inertia-link>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout';
import axios from 'axios';
import store from '@/store';

export default {
  store,
  layout: Layout,
  data() {
    return {
      data: []
    };
  },
  methods: {
    refresh() {
      this.$store.commit('refreshShoppingCartProducts');
    },
    quantityInputOnBeforeInput(event, idx) {
      const values = event.target.value.split('');
      const selectionStart = event.target.selectionStart;

      values.splice(selectionStart, event.target.selectionEnd - event.target.selectionStart, event.data);

      let value = values.join('');

      if (!(value.match(/^[1-9][0-9]*$/) instanceof Array)) {
        event.preventDefault();
      }
    }
  }
}
</script>