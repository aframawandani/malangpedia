<template>
  <div>
    <div class="breadcrumb-option">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="breadcrumb__links">
              <inertia-link href="/"><i class="fa fa-home"></i> Home</inertia-link>
              <inertia-link href="/">Pesanan</inertia-link>
              <span>{{orderId}}</span>
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
                  <tr v-for="(order_product) in data.products" v-bind:key="order_product.product_id">
                    <td class="cart__product__item">
                      <img v-bind:src="order_product.image" width="90" alt="">
                      <div class="cart__product__item__title">
                        <h6>{{order_product.name}}</h6>
                        <div class="rating">
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                        </div>
                      </div>
                    </td>
                    <td class="cart__price">Rp {{order_product.price.toLocaleString('id-ID')}}</td>
                    <td class="cart__quantity">{{order_product.quantity}}</td>
                    <td class="cart__total">Rp {{(order_product.price * order_product.quantity).toLocaleString('id-ID')}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 offset-lg-8">
            <div class="cart__total__procced">
              <h6>Total Pesanan</h6>
              <ul>
                <li>Total <span>Rp {{data.reduce((acc, cur) => acc + cur.quantity * cur.price, 0).toLocaleString('id-ID')}}</span></li>
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
  props: {
    orderId: Number
  },
  layout: Layout,
  data() {
    return {
      data: []
    };
  },
  mounted() {
    console.log(this.orderId);
  }
}
</script>
