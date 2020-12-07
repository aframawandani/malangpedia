<template>
  <div class="sidebar__categories">
    <div class="section-title">
      <h4>Categories</h4>
    </div>
    <div class="categories__accordion">
      <div class="accordion" id="categoriesAccordion">
        <div v-for="(category, i) in data" v-bind:key="`category${i}`" class="card">
          <div class="card-heading active">
            <a data-toggle="collapse" v-bind:data-target="`#collapse${category.category_id}`">{{category.name}}</a>
          </div>
          <div class="collapse" v-bind:id="`collapse${category.category_id}`" data-parent="#categoriesAccordion">
            <div class="card-body">
              <ul>
                <li v-for="child_category in category.child_categories" v-bind:key="child_category.category_id">
                  <inertia-link v-bind:href="child_category.slug">{{child_category.name}}</inertia-link>
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
