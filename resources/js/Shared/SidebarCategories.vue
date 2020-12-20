<template>
  <div class="sidebar__categories">
    <div class="section-title">
      <h4>Categories</h4>
    </div>
    <div class="categories__accordion">
      <div class="accordion" id="categoriesAccordion">
        <div v-for="(category, i) in data" :key="`category${i}`" class="card">
          <div class="card-heading active">
            <a data-toggle="collapse" :data-target="`#collapse${category.category_id}`" :aria-expanded="pathname.search(category.url) === 0">{{category.name}}</a>
          </div>
          <div :class="`collapse${pathname.search(category.url) === 0 ? ' show' : ''}`" :id="`collapse${category.category_id}`" data-parent="#categoriesAccordion">
            <div class="card-body">
              <ul>
                <li>
                  <inertia-link :href="category.url">Semua</inertia-link>
                </li>
                <li v-for="child_category in category.child_categories" :key="child_category.category_id">
                  <inertia-link :href="child_category.url">{{child_category.name}}</inertia-link>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import CategoryListItem from './CategoryListItem';

export default {
  components: {
    CategoryListItem
  },
  data() {
    return {
      pathname: document.location.pathname,
      isLoading: true,
      data: []
    };
  },
  mounted() {
    axios
    .get('/api/category')
    .then(response => {
      this.data = response.data.data;
    })
    .finally(() => {
      this.isLoading = false;
    });
  }
}
</script>
