<template>
  <div id="app">
    <header class="main-header">
      <a href="/" class="logo">
        <span class="logo-lg">Malang<strong style="font-weight: 600;">Pedia</strong></span>
      </a>
      <nav class="navbar navbar-static-top">
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs">Admin</span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">Keluar</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <main-sidebar />
    <slot />
  </div>
</template>

<script>
import MainSidebar from './MainSidebar';

export default {
  components: {
    MainSidebar
  },
  methods: {
  }
}
</script>
