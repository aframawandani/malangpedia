<template>
  <div>
    <div id="preloder">
      <div class="loader"></div>
    </div>

    <header class="header">
      <div class="container-fluid">
        <div class="row">
          <div class="col flex-grow-0">
            <div class="header__logo">
              <inertia-link href="/">
                <h1>MalangPedia</h1>
              </inertia-link>
            </div>
          </div>
          <div class="col">
            <nav class="header__menu">
              <ul>
                <li class="active"><inertia-link href="/">Home</inertia-link></li>
                <li><inertia-link href="/category/komputer-laptop/komputer-desktop">Komputer Desktop</inertia-link></li>
                <li><inertia-link href="/category/komputer-laptop/laptop">Laptop</inertia-link></li>
                <li><inertia-link href="/category/karya-nusantara">Karya Nusantara</inertia-link></li>
              </ul>
            </nav>
          </div>
          <div class="col flex-grow-0">
            <div v-if="!isGettingUser" class="header__right">
              <div v-if=" (user instanceof Object)" class="header__right__widget">
                <li>
                  <div class="dropdown" id="shoppingCartProductsDropdown">
                    <inertia-link class="shopping-cart" id="shoppingCartDropdownLink" href="/shopping-cart">
                      <i class="feather icon-shopping-cart"></i>
                      <div class="tip">{{$store.state.shoppingCartProducts.length}}</div>
                    </inertia-link>
                  </div>
                </li>
              </div>
              <div class="header__right__auth">
                <inertia-link v-if="!(user instanceof Object)" href="/auth/login">Login</inertia-link>
                <inertia-link v-if="!(user instanceof Object)" href="/auth/register">Register</inertia-link>
                <inertia-link v-if="user instanceof Object" href="/profile">{{user.name}}</inertia-link>
              </div>
            </div>
          </div>
        </div>
        <div class="canvas__open">
          <i class="fa fa-bars"></i>
        </div>
      </div>
    </header>
    <slot />
  </div>
</template>

<style>
.dropdown-menu {
  overflow: hidden;
}

#shoppingCartProductsDropdownMenu {
  left: auto;
  right: 0;
}
</style>
<script>
import axios from 'axios';
import store from '@/store';

export default {
  store,
  data() {
    return {
      isGettingUser: true,
      user: null,
      shopping_cart_products: []
    };
  },
  mounted() {
    $(".loader").fadeOut();
    $("#preloder").delay(200).fadeOut("slow");

    axios.get('/api/auth/user')
    .then(response => {
      if (response.data instanceof Object) {
        const data = response.data.data;

        if (data instanceof Object) {
          this.user = data;

          this.$store.commit('refreshShoppingCartProducts');
        }
      }
    })
    .catch(error => {})
    .finally(() => {
      this.isGettingUser = false;
    });
  },
  updated() {
    this.$store.commit('refreshLocationPathname');
  }
}
</script>