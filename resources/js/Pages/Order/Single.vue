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
        <form class="order__form">
          <div class="row">
            <div class="col-lg-8">
              <h5>Pesanan</h5>
              <div class="row">
                <div class="col-12">
                  <div class="order__form__input">
                    <p>Alamat <span>*</span></p>
                    <input id="addressInput" name="address" type="text" spellcheck="false" autocomplete="off" v-model="input.address">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="order__form__input">
                    <p>Catatan</p>
                    <textarea id="noteTextarea" name="note" spellcheck="false" autocomplete="off" rows="6" style="width: 100%;" v-model="input.note"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="order__order">
                <h5>Pesanan Anda</h5>
                <div class="order__order__product">
                  <ul>
                    <li>
                      <span class="top__text">Produk</span>
                      <span class="top__text__right">Total</span>
                    </li>
                    <li v-for="(shoppingCartProduct, i) in $store.state.shoppingCartProducts" v-bind:key="shoppingCartProduct.product_id">{{(i + 1).toString().padStart(2, '0')}}. {{shoppingCartProduct.name}} x {{shoppingCartProduct.quantity}} <span>Rp {{(shoppingCartProduct.quantity * shoppingCartProduct.price).toLocaleString('id-ID')}}</span></li>
                    <li><span>Rp {{$store.state.shoppingCartProducts.reduce((acc, cur, idx) => acc + cur.quantity * cur.price, 0).toLocaleString('id-ID')}}</span></li>
                  </ul>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button class="site-btn" type="button" @click="refresh">Refresh</button>
                  </div>
                  <div class="col-6">
                    <button class="site-btn" type="submit">Pesan</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
    <div class="modal" id="testModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <p>Apakah Anda yakin akan memesan produk tersebut?</p>
          </div>
          <div class="modal-footer">
            <button class="site-btn" type="button" @click="yesOrderConfirmationButtonOnClick">Ya</button>
            <button class="site-btn" type="button">Tidak</button>
          </div>
        </div>
      </div>
    </div>
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
      data: [],
      input: {
        address: null,
        note: null
      }
    };
  },
  methods: {
    refresh() {
      this.$store.commit('refreshShoppingCartProducts');
    },
    yesOrderConfirmationButtonOnClick() {
      const data = {
        _method: 'PUT',
        address: this.input.address,
        note: this.input.note,
        products: this.data.map(shoppingCartProduct => {
          return {
            product_id: shoppingCartProduct.product_id,
            quantity: shoppingCartProduct.quantity
          };
        })
      };

      axios({
        method: 'POST',
        url: '/api/order',
        data
      })
      .then(response => {
        if (response.data instanceof Object) {
          const data = response.data.data;

          if (data instanceof Object) {
            this.$inertia.visit(`/order/${data.order_id}`);
          }
        }
      });
    }
  },
  mounted() {
    $('#testModal').modal('show');
    axios.get('/api/shopping-cart-product')
    .then(response => {
      if (response.data instanceof Object) {
        const data = response.data.data;

        if (data instanceof Array) {
          this.data = data;
        }
      }
    });
  }
}
</script>
