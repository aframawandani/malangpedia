<template>
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">
          <strong>MENU</strong>
        </li>
        <sidebar-menu-list-item v-for="(menu, i) in user.menus" :key="i" :menu="menu" />
      </ul>
    </section>
  </aside>
</template>

<script>
import axios from 'axios';
import SidebarMenuListItem from './SidebarMenuList';

export default {
  components: {
    SidebarMenuListItem
  },
  data()
  {
    return {
      user: {}
    };
  },
  mounted() {
    axios
    .get('/api/auth/user')
    .then(response => {
      this.user = response.data;
    });
  }
}
</script>
