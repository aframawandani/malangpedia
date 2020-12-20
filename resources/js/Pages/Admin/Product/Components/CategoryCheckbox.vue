<template>
  <div class="checkbox">
    <label>
      <input type="checkbox" name="category_ids[]" form="insertForm" :checked="category.category_id in checkedCategories" :value="category.category_id" @change="test">
      <span class="text" v-html="category.name"></span>
    </label>
    <category-checkbox v-for="child_category in category.child_categories" :key="child_category.category_id" :category="child_category" :checkedCategories="checkedCategories" />
  </div>
</template>

<script>
export default {
  name: 'category-checkbox',
  props: {
    category: Object,
    checkedCategories: Object,
    onChange: Function
  },
  methods: {
    test(event) {
      console.log(this.onChange);
    }
  }
}
</script>
