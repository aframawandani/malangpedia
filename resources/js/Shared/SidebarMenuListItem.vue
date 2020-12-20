<template>
  <li :class="menu.children instanceof Array ? 'treeview' : null">
    <inertia-link v-if="typeof menu.url === 'string'" :href="menu.url">
      <i v-if="typeof menu.icon === 'string'" :class="`feather icon-${menu.icon}`"></i>
      <span class="text">{{menu.label}}</span>
    </inertia-link>
    <a v-if="typeof menu.url !== 'string'" href="#">
      <i v-if="typeof menu.icon === 'string'" :class="`feather icon-${menu.icon}`"></i>
      <span class="text">{{menu.label}}</span>
    </a>
    <ul v-if="(menu.children instanceof Array)" class="treeview-menu">
      <sidebar-menu-list-item v-for="(childrenMenu, i) in menu.children instanceof Array ? menu.children : []" :key="i" :menu="childrenMenu" />
    </ul>
  </li>
</template>

<script>
export default {
  name: 'SidebarMenuListItem',
  props: {
    menu: Object
  }
}
</script>