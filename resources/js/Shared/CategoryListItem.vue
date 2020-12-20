<template>
  <div class="card">
    <div class="card-heading active">
      <button v-if="category.child_categories.length > 0" data-toggle="collapse" v-bind:class="getClass(category)" v-bind:data-target="`#accordion${category.category_id}`" v-bind:aria-expanded="getAriaExpanded(category)"></button>
      <inertia-link>{{category.name}}</inertia-link>
    </div>
    <div v-if="category.child_categories.length > 0" v-bind:id="`accordion${category.category_id}`" v-bind:class="'collapse'+(isActive(category) ? ' show' : '')" v-bind:data-parent="typeof category.parent_category_id === 'number' ? `#accordion${category.parent_category_id}` : '#accordion0'">
      <div class="card-body">
        <div class="accordion">
          <category v-for="(child_category, i) in category.child_categories" v-bind:key="i" v-bind:category="child_category" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'category',
  props: {
    category: Object
  },
  methods: {
    isActive(category) {
      return category instanceof Object ? document.location.pathname.search(`/category${category.url}`) === 0 : false;
    },
    getClass(category) {
      return category instanceof Object ? this.isActive(category) ? null : 'collapsed' : null;
    },
    getAriaExpanded(category) {
      return category instanceof Object ? this.isActive(category) ? 'true' : 'false' : null;
    }
  }
}
</script>