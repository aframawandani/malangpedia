import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

const cancelToken = axios.CancelToken.source();
const store = new Vuex.Store({
  state: {
    data: []
  },
  mutations: {
    refresh(state) {
      axios.get('/api/shopping-cart-product')
      .then(response => {
        if (response.data instanceof Object) {
          state.data = response.data.data;
        }
      });
    },
    insert(state, {product_id, quantity}) {
      axios({
        method: 'POST',
        url: '/api/shopping-cart-product',
        data: {
          _method: 'PUT',
          product_id,
          quantity
        }
      })
      .then(response => {
        if (response.data instanceof Object) {
          state.data.push(data);
        }
      });
    },
    update(state, {idx, quantity}) {
      cancelToken.cancel();

      const shopping_cart_product_id = state.data[idx].shopping_cart_product_id;

      state.data[idx].quantity = quantity;

      axios({
        method: 'POST',
        url: '/api/shopping-cart-product',
        data: {
          _method: 'PATCH',
          shopping_cart_product_id,
          quantity
        },
        cancelToken
      })
      .then(response => {
        if (response.data instanceof Object) {
          state.data[idx].quantity = quantity;
        }
      });
    },
    increaseQuantity(state, {idx}) {
      let quantity = state.shoppingCartProducts[idx].quantity;

      this.update(i, ++quantity);
    },
    decreaseQuantity(state, {idx}) {
      let quantity = state.shoppingCartProducts[idx].quantity;

      if (quantity > 1) {
        this.update(idx, --quantity);
      }
    },
    remove(state, {idx}) {
      const shopping_cart_product_id = state.data[idx].shopping_cart_product_id;

      axios({
        method: 'POST',
        url: '/api/shopping-cart-product',
        data: {
          _method: 'DELETE',
          shopping_cart_product_id
        }
      })
      .then(response => {
        if (response.data instanceof Object) {
          state.data.splice(idx);
        }
      });
    },
  }
});

export default store;
