<template>
  <div class="review-wrapper mt-4">
    <div v-for="(v, i) in (loading ? (data instanceof Array ? data : new Array(4)) : [])" :key="i" class="review">
      <div class="loading-value" style="height: 16px; min-width: 120px; width: 15%;"></div>
      <div class="loading-value" style="height: 16px; margin-top: 4px; width: 80px;"></div>
      <div class="loading-value" style="height: 16px; margin-top: 4px; min-width: 210px; width: 30%;"></div>
    </div>
    <div v-if="total === 0" class="review">
      <div class="review-empty-message">Belum ada review</div>
    </div>
    <div v-for="review in (loading ? [] : data)" :key="review.review_id" class="review">
      <div class="review-user">{{review.user_name}}</div>
      <div class="review-rating">
        <i v-for="(v, i) in (new Array(review.rating))" :key="i" class="rating-star feather icon-star-on"></i>
        <i v-for="(v, j) in (new Array(5 - review.rating))" :key="`on-${j}`" class="rating-star feather icon-star"></i>
      </div>
      <div class="review-content">{{review.content}}</div>
    </div>
    <ul v-if="total > 0 && links.length > 0" class="review-pagination-wrapper">
      <li class="review-pagination">
        <a class="review-pagination-link" :disabled="paginationPreviousUrl === null">
          <i class="feather icon-chevron-left"></i>
        </a>
      </li>
      <li v-for="(link, i) in paginationLinks" :key="`link-${i}`" class="review-pagination">
        <a :class="`review-pagination-link${link.active ? ' active' : ''}`" @click="getReviews(link.label)">{{link.label}}</a>
      </li>
      <li class="review-pagination">
        <a class="review-pagination-link" :disabled="paginationNextUrl === null">
          <i class="feather icon-chevron-right"></i>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
let currentPage = 1;

export default {
  props: {
    productSlug: String,
  },
  data() {
    return {
      loading: true,
      data: [],
      links: [],
      total: null,
    };
  },
  computed: {
    paginationLinks() {
      return this.links instanceof Array && this.links.length > 0 ? this.links.splice(1, Math.max(this.links.length - 2, 0)) : [];
    },
    paginationPreviousUrl() {
      return this.links instanceof Array && this.links.length > 0 ? this.links[0].url : null;
    },
    paginationNextUrl() {
      return this.links instanceof Array && this.links.length > 0 ? this.links[this.links.length - 1].url : null;
    },
  },
  methods: {
    getReviews(page) {
      if (typeof page !== 'number' || page < 1) {
        page = 1;
      }

      currentPage = page;

      axios
      .get(`/api/review/${this.productSlug}${page > 1 ? `?page=${page}` : ''}`)
      .then(response => {
        if (response.data instanceof Object) {
          if (response.data.data instanceof Array) {
            this.data = response.data.data;
          }

          if (response.data.links instanceof Array) {
            this.links = response.data.links;
          }

          if (typeof response.data.total === 'number') {
            this.total = response.data.total;
          }
        }
      })
      .finally(() => {
        this.loading = false;
      });
    },
  },
  mounted() {
    this.getReviews();
  }
}
</script>
