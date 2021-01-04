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
        <div class="row mb-4">
          <div class="col-lg-12">
            <div class="cart__total__procced">
              <h6>Detail Pesanan</h6>
              <div>
                <div class="row">
                  <div class="col-lg-5">
                    <ul class="mb-0">
                      <li>Waktu <span>{{typeof data.created_at === 'number' ? getCreatedAtFullDateWithTime() : ''}}</span></li>
                      <li>Total <span>Rp {{data.products instanceof Array ? data.products.reduce((acc, cur, idx) => acc + cur.product_price * cur.quantity, 0).toLocaleString('id-ID') : ''}}</span></li>
                    </ul>
                  </div>
                  <div class="col-lg-2"></div>
                  <div class="col-lg-5">
                    <ul>
                      <li>Alamat <span>{{typeof data.address === 'string' ? data.address : ''}}</span></li>
                      <li>Status <span>{{typeof data.status_idx === 'number' ? getStatus() : ''}}</span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
                  <tr v-for="(order_product) in data.products" :key="order_product.product_id">
                    <td class="cart__product__item">
                      <img :src="`/assets/images/products/${order_product.product_image}.jpg`" width="90" alt="">
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
                    <td class="cart__price">Rp {{order_product.product_price.toLocaleString('id-ID')}}</td>
                    <td class="cart__quantity">{{order_product.quantity}}</td>
                    <td class="cart__total">Rp {{(order_product.product_price * order_product.quantity).toLocaleString('id-ID')}}</td>
                  </tr>
                </tbody>
              </table>
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
import helper from '@/helper';
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
  methods: {
    getCreatedAtFullDateWithTime() {
      return helper.getFullDateWithTime(this.data.created_at);
    },
    getStatus() {
      return helper.getOrderStatus(this.data.status_idx);
    }
  },
  mounted() {
    axios.get(`/api/order/${this.orderId}`).then(response => {
      if (response.data instanceof Object) {
        const data = response.data.data;

        if (data instanceof Object) {
          this.data = data;
        }
      }
    });
  }
}
</script>
