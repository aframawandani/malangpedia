<template>
  <div class="modal" id="writeOrEditReviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{product.user_review instanceof Object ? 'Edit' : 'Tulis'}} Review</h5>
        </div>
        <div class="modal-body">
          <form id="writeOrEditReviewForm" @submit.prevent="writeOrEditReviewFormOnSubmit">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-3">
                  <img class="review-product-image" :src="product.image">
                  <h6 class="review-product-name">{{product.name}}</h6>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <textarea class="review-content-textarea" rows="6" spellcheck="false" v-model="input.content"></textarea>
                  </div>
                  <h6 class="review-rating-label">Rating</h6>
                  <div class="d-flex mt-1">
                    <div class="custom-rating">
                      <div class="star">
                        <input class="custom-rating-input" id="star1" type="radio" name="rating" value="1" @input="ratingStarInputOnChange" />
                        <label class="custom-rating-label" for="star1">
                          <i :class="`rating-star feather icon-star${input.rating >= 1 ? '-on' : ''}`"></i>
                        </label>
                      </div>
                      <div class="star">
                        <input class="custom-rating-input" id="star2" type="radio" name="rating" value="2" @input="ratingStarInputOnChange" />
                        <label class="custom-rating-label" for="star2">
                          <i :class="`rating-star feather icon-star${input.rating >= 2 ? '-on' : ''}`"></i>
                        </label>
                      </div>
                      <div class="star">
                        <input class="custom-rating-input" id="star3" type="radio" name="rating" value="3" @input="ratingStarInputOnChange" />
                        <label class="custom-rating-label" for="star3">
                          <i :class="`rating-star feather icon-star${input.rating >= 3 ? '-on' : ''}`"></i>
                        </label>
                      </div>
                      <div class="star">
                        <input class="custom-rating-input" id="star4" type="radio" name="rating" value="4" @input="ratingStarInputOnChange" />
                        <label class="custom-rating-label" for="star4">
                          <i :class="`rating-star feather icon-star${input.rating >= 4 ? '-on' : ''}`"></i>
                        </label>
                      </div>
                      <div class="star">
                        <input class="custom-rating-input" id="star5" type="radio" name="rating" value="5" @input="ratingStarInputOnChange" />
                        <label class="custom-rating-label" for="star5">
                          <i :class="`rating-star feather icon-star${input.rating >= 5 ? '-on' : ''}`"></i>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="general-button" type="button" @click="writeOrEditReviewCancelButtonOnClick">Batal</button>
          <button class="general-button solid" type="submit" form="writeOrEditReviewForm">Submit</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
let $writeOrEditReviewModal;

export default {
  props: {
    product: Object,
  },
  data() {
    return {
      errors: {},
      input: {
        _method: 'PUT',
        product_id: null,
        content: null,
        rating: null,
      },
    };
  },
  methods: {
    writeOrEditReviewFormOnSubmit(event) {
      this.errors = {};

      axios({
        method: 'POST',
        url: '/api/review',
        data: this.input,
      })
      .then(response => {
        this.$emit('writereviewsuccess');
      });
    },
    writeOrEditReviewCancelButtonOnClick() {
      $writeOrEditReviewModal.modal('hide');
    },
    ratingStarInputOnChange(event) {
      if (event.target.checked) {
        this.input.rating = parseInt(event.target.value);
      }
    },
    ratingStarInputOnMouseEnter(event) {
    }
  },
  mounted() {
    $writeOrEditReviewModal = $(this.$el);

    $writeOrEditReviewModal.on('hide.bs.modal', () => {
      this.input.content = this.product.user_review?.content;
      this.input.rating = this.product.user_review?.rating;
    });
  },
  watch: {
    product() {
      this.input.product_id = this.product.product_id;
      this.input.content = this.product.user_review?.content;
      this.input.rating = this.product.user_review?.rating;
    }
  },
}
</script>