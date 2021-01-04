<template>
  <div>
    <div class="breadcrumb-option">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="breadcrumb__links">
              <inertia-link href="/"><i class="fa fa-home"></i> Home</inertia-link>
              <span>Pesanan</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="order spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="order__table">
              <table>
                <thead>
                  <tr>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Alamat</th>
                    <th>Waktu</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(order, i) in this.data" :key="order.order_id" @click="(order_id => {visitOrder(order_id);})(order.order_id)">
                    <td class="order__products">
                      {{order.products.reduce((acc, cur, idx) => `${acc + (idx > 0 ? ', ' : '')}${cur.quantity}x ${cur.product_name}`, '')}}
                    </td>
                    <td class="order__total">Rp {{order.products.reduce((acc, cur, idx) => acc + cur.product_price * cur.quantity, 0).toLocaleString('id-ID')}}</td>
                    <td class="order__address">{{order.address}}</td>
                    <td class="order__time">
                      {{(time => {
                        const date = new Date(time);

                        return `${date.getDate().toString().padStart(2, '0')}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getFullYear().toString().padStart(2, '0')} pukul ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`;
                      })(order.created_at)}}
                    </td>
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
    visitOrder(orderId) {
      this.$inertia.visit(`/order/${orderId}`);
    }
  },
  mounted() {
    axios
    .get('/api/order')
    .then(response => {
      if (response.data instanceof Object) {
        const data = response.data.data;

        if (data instanceof Object) {
          this.data = data;
        }
      }
    })
    .catch(error => {
    });
  }
}
</script>
