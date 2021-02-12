<template>
  <div class="checkbox">
    <label>
      <input type="checkbox" name="categories[]" :form="typeof form === 'string' ? form : null" :checked="category.category_id in checkedCategories" :value="category.category_id" @change="onChange">
      <span class="text" v-html="category.name"></span>
    </label>
    <category-checkbox v-for="child_category in category.child_categories" :key="child_category.category_id" :form="form" :category="child_category" :checkedCategories="checkedCategories" />
  </div>
</template>

<script>
export default {
  name: 'category-checkbox',
  props: {
    form: String,
    category: Object,
    checkedCategories: Object,
  },
  methods: {
    onChange(event) {
      this.$emit('test', event);
    }
  }
}
</script>
