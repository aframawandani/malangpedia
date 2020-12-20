import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import {Inertia} from '@inertiajs/inertia';

Vue.use(Vuex);

let shoppingCartProductCancelTokenSource;
const store = new Vuex.Store({
  state: {
    shoppingCartProducts: [],
    locationPathname: document.location.pathname
  },
  mutations: {
    refreshLocationPathname(state) {
      state.locationPathname = document.location.pathname;
    },
    refreshShoppingCartProducts(state) {
      axios.get('/api/shopping-cart-product')
      .then(response => {
        if (response.data instanceof Object) {
          const data = response.data.data;

          if (data instanceof Array) {
            state.shoppingCartProducts = data;
          }
        }
      });
    },
    insertShoppingCartProduct(state, {product_id, quantity}) {
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
          const data = response.data.data;

          if (data instanceof Object) {
            if (response.status === 201) {
              state.shoppingCartProducts.push(data);
            }
            else if (response.status === 200) {
              state.shoppingCartProducts[idx].quantity = data.quantity;
            }
          }
        }
      })
      .catch(error => {
        if (error.response.status === 401) {
          Inertia.visit('/auth/login');
        }
      });
    },
    updateQuantityShoppingCartProduct(state, {idx, quantity}) {
      if (shoppingCartProductCancelTokenSource instanceof Object) {
        shoppingCartProductCancelTokenSource.cancel();
      }

      shoppingCartProductCancelTokenSource = axios.CancelToken.source();

      const product_id = state.shoppingCartProducts[idx].product_id;

      state.shoppingCartProducts[idx].quantity = quantity;

      axios({
        method: 'POST',
        url: '/api/shopping-cart-product',
        data: {
          _method: 'PATCH',
          product_id,
          quantity
        },
        cancelToken: shoppingCartProductCancelTokenSource.token
      })
      .then(response => {
        if (response.data instanceof Object && response.data.data instanceof Object && typeof response.data.data.quantity === 'number') {
          state.shoppingCartProducts[idx].quantity = response.data.data.quantity;
        }
      })
      .catch(error => {
        if (error.response instanceof Object && error.response.status === 401) {
          Inertia.visit('/auth/login');
        }
      });
    },
    increaseQuantityShoppingCartProduct(state, {idx}) {
      let quantity = state.shoppingCartProducts[idx].quantity;

      quantity++;

      this.commit('updateQuantityShoppingCartProduct', {idx, quantity});
    },
    decreaseQuantityShoppingCartProduct(state, {idx}) {
      let quantity = state.shoppingCartProducts[idx].quantity;

      if (quantity > 1) {
        quantity--;

        this.commit('updateQuantityShoppingCartProduct', {idx, quantity});
      }
    },
    removeShoppingCartProduct(state, {idx}) {
      const product_id = state.shoppingCartProducts[idx].product_id;

      axios({
        method: 'POST',
        url: '/api/shopping-cart-product',
        data: {
          _method: 'DELETE',
          product_id: [product_id]
        }
      })
      .then(response => {
        state.shoppingCartProducts.splice(idx, 1);
      })
      .catch(error => {
        if (error.response.status === 401) {
          Inertia.visit('/auth/login');
        }
      });
    }
  }
});

export default store;
