<template>
  <div>
    <div class="breadcrumb-option">
      <div class="container">
         <div class="row">
          <div class="col-lg-12">
            <div v-if="isLoading" class="loading-value" style="height: 16px; width: 40%;"></div>
            <div v-if="!isLoading" class="breadcrumb__links">
              <inertia-link href="/"><i class="fa fa-home"></i> Home</inertia-link>
              <inertia-link v-for="(category, i) in data.categories" :key="i" :href="category.url">{{category.name}}</inertia-link>
              <span>{{isLoading ? '?': data.name}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="product-details spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <div class="product__details__pic">
              <div class="product__details__slider__content">
                <div class="product__details__pic__slider">
                  <img v-if="!isLoading" data-hash="product-1" class="product__big__img" :src="typeof data.image === 'string' ? data.image : '/assets/images/no-product-image.svg'" alt="">
                </div>
              </div>
            </div>
            <div v-if="typeof data.image === 'string' || (data.galleries instanceof Array && data.galleries.length > 0)" class="gallery-thumbnail-wrapper owl-carousel test">
              <div class="gallery-thumbnail">
                <img :src="data.image">
              </div>
              <div v-for="(gallery, i) in data.galleries" :key="i" class="gallery-thumbnail">
                <img :src="gallery.image">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="product__details__text">
              <dl class="product-detail mb-3">
                <dd class="product-detail-value">
                  <div v-if="isLoading" class="loading-value" style="height: 26px; width: 280px;"></div>
                  <div class="d-flex mt-2">
                    <div v-if="isLoading" class="loading-value" style="height: 16px; width: 80px;"></div>
                    <div v-if="isLoading" class="loading-value" style="height: 16px; margin-left: 10px; width: 54px;"></div>
                  </div>
                  <h3 v-if="!isLoading" class="product-name">{{data.name}}</h3>
                  <div class="product-quick-details">
                    <div v-if="!isLoading" class="product-rating">
                      <div class="rating-star-wrapper">
                        <i class="rating-star feather icon-star"></i>
                        <i class="rating-star-on feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating, 0), 1) * 100}%;`"></i>
                      </div>
                      <div class="rating-star-wrapper">
                        <i class="rating-star feather icon-star"></i>
                        <i class="rating-star-on feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating - 1, 0), 1) * 100}%;`"></i>
                      </div>
                      <div class="rating-star-wrapper">
                        <i class="rating-star feather icon-star"></i>
                        <i class="rating-star-on feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating - 2, 0), 1) * 100}%;`"></i>
                      </div>
                      <div class="rating-star-wrapper">
                        <i class="rating-star feather icon-star"></i>
                        <i class="rating-star-on feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating - 3, 0), 1) * 100}%;`"></i>
                      </div>
                      <div class="rating-star-wrapper">
                        <i class="rating-star feather icon-star"></i>
                        <i class="rating-star-on feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating - 4, 0), 1) * 100}%;`"></i>
                      </div>
                    </div>
                    <span v-if="!isLoading" class="product-sold">{{data.sold}} terjual</span>
                  </div>
                </dd>
              </dl>
              <dl class="product-detail py-4">
                <dt class="product-detail-name">
                  <div v-if="isLoading" class="loading-value" style="height: 18px; width: 60px;"></div>
                  <span v-if="!isLoading" class="text">Harga</span>
                </dt>
                <dd class="product-detail-value">
                  <div v-if="isLoading" class="loading-value" style="height: 26px; width: 280px;"></div>
                  <h3 v-if="!isLoading" class="product-price">Rp {{Number.parseFloat(data.price).toLocaleString('id-ID')}}</h3>
                </dd>
              </dl>
              <dl class="product-detail py-4 border-top">
                <dt class="product-detail-name">
                  <div v-if="isLoading" class="loading-value" style="height: 18px; width: 60px;"></div>
                  <span v-if="!isLoading" class="text">Jumlah</span>
                </dt>
                <dd calss="product-detail-value">
                  <div v-if="isLoading" class="loading-value" style="height: 32px; width: 160px;"></div>
                  <div v-if="isLoading" class="loading-value mt-2" style="height: 16px; width: 70px;"></div>
                  <div v-if="!isLoading" class="product-quantity-input-wrapper">
                    <button class="product-quantity-modifier-button" @click="decreaseQuantityButtonOnClick">
                      <i class="feather icon-minus"></i>
                    </button>
                    <input class="product-quantity-input" v-model="input.quantity" @beforeinput="quantityInputOnBeforeInput">
                    <button class="product-quantity-modifier-button" @click="increaseQuantityButtonOnClick">
                      <i class="feather icon-plus"></i>
                    </button>
                  </div>
                  <h6 v-if="!isLoading && typeof data.quantity === 'number'" class="product-quantity">Tersisa {{data.quantity}}</h6>
                </dd>
              </dl>
              <dl class="product-detail py-4 border-top">
                <dd class="product-detail-value">
                  <div class="d-flex">
                    <div v-if="isLoading" class="loading-value" style="height: 40px; width: 180px;"></div>
                    <div v-if="isLoading" class="loading-value ml-2" style="height: 40px; width: 180px;"></div>
                    <button v-if="!isLoading" class="product-add-to-cart-button" @click="productAddToCartButtonOnClick">Masukkan Keranjang</button>
                    <button v-if="!isLoading" class="product-buy-now-button ml-2">Beli Sekarang</button>
                  </div>
                </dd>
              </dl>
              <div v-if="isLoading" class="loading-value" style="height: 62px; margin-bottom: 25px;"></div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="product__details__tab">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#descriptionTab" role="tab">Deskripsi</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#reviewTab" role="tab">Review</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="descriptionTab" role="tabpanel">
                  <h6>Deskripsi</h6>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 40%;"></div>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 50%;"></div>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 30%;"></div>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 20%;"></div>
                  <div v-if="isLoading" class="loading-value" style="height: 24px; margin-bottom: 24px; width: 60%;"></div>
                  <p v-if="!isLoading" v-html="data.description"></p>
                </div>
                <div class="tab-pane" id="reviewTab" role="tabpanel">
                  <div class="d-flex align-item">
                    <div class="d-table">
                      <div class="rating-score">
                        <div v-if="isLoading" class="loading-value" style="height: 64px; margin: 0 auto; width: 80px;"></div>
                        <span v-if="!isLoading">{{typeof data.rating === 'number' ? Math.round(data.rating * 10) / 10 : '?'}}</span>
                      </div>
                      <div v-if="isLoading" class="loading-value" style="height: 24px; margin-top: 8px; width: 120px;"></div>
                      <div v-if="isLoading" class="loading-value" style="height: 24px; margin: 8px auto 0 auto; width: 64px;"></div>
                      <div v-if="!isLoading" class="d-flex mt-2">
                        <div class="rating-star-wrapper">
                          <i class="rating-star-big feather icon-star"></i>
                          <i class="rating-star-on-big feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating, 0), 1) * 100}%;`"></i>
                        </div>
                        <div class="rating-star-wrapper">
                          <i class="rating-star-big feather icon-star"></i>
                          <i class="rating-star-on-big feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating - 1, 0), 1) * 100}%;`"></i>
                        </div>
                        <div class="rating-star-wrapper">
                          <i class="rating-star-big feather icon-star"></i>
                          <i class="rating-star-on-big feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating - 2, 0), 1) * 100}%;`"></i>
                        </div>
                        <div class="rating-star-wrapper">
                          <i class="rating-star-big feather icon-star"></i>
                          <i class="rating-star-on-big feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating - 3, 0), 1) * 100}%;`"></i>
                        </div>
                        <div class="rating-star-wrapper">
                          <i class="rating-star-big feather icon-star"></i>
                          <i class="rating-star-on-big feather icon-star-on" :style="`width: ${Math.min(Math.max(data.rating - 4, 0), 1) * 100}%;`"></i>
                        </div>
                      </div>
                      <div v-if="!isLoading" class="d-flex align-items-center justify-content-center mt-1">
                        <i class="feather icon-user"></i>
                        <span class="text d-block ml-1">{{data.rating_quantity}} User</span>
                      </div>
                    </div>
                    <button v-if="isUserLoggedIn" class="write-review-button" @click="showWriteOrEditReviewModal">{{data.user_review instanceof Object ? 'Edit' : 'Tulis'}} Review</button>
                  </div>
                  <review-section :product-slug="productSlug" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="modal" id="errorModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <p v-for="(error, i) in errors" :key="i">{{error.reduce((acc, cur, idx) => acc + (idx > 0 ? ', ' : '') + cur, '')}}</p>
          </div>
          <div class="modal-footer">
            <button class="site-btn" type="button" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
    <write-or-edit-review-modal v-if="isUserLoggedIn" :product="data" ref="writeOrEditReviewModal" @writereviewsuccess="onWriteReviewSuccess" />
  </div>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
import scripts from '@/scripts';
import store from '@/store';
import Layout from '@/Shared/Layout';
import ReviewSection from './Components/ReviewSection';
import WriteOrEditReviewModal from './Components/WriteOrEditReviewModal.vue';

let $errorModal, $productBigImg, $zoomImg, $galleryThumbnailWrapper, $writeOrEditReviewModal;

function product_thumbs (num) {
  var thumbs = document.querySelectorAll('.product__thumb a');
  thumbs.forEach(function (e) {
    e.classList.remove("active");
    if(e.hash.split("-")[1] == num) {
      e.classList.add("active");
    }
  })
}

export default {
  components: {
    ReviewSection,
    WriteOrEditReviewModal,
  },
  props: {
    productSlug: String,
    isUserLoggedIn: Boolean,
  },
  layout: Layout,
  data() {
    return {
      isLoading: true,
      data: {},
      input: {
        quantity: 1,
        rating: 4
      },
      errors: {}
    }
  },

  methods: {
    errorModalOKButtonOnClick() {
      $errorModal.modal('hide');
    },

    onWriteReviewSuccess() {
      console.log('test');
    },

    productAddToCartButtonOnClick() {
      this.$store.commit('insertShoppingCartProduct', {
        product_id: this.data.product_id,
        quantity: parseInt(this.input.quantity),
        callback: promise => {
          promise.then(responseOrError => {
            if (responseOrError instanceof Error) {
              const error = responseOrError;

              if (error.response.status === 422) {
                const {errors} = error.response.data;

                if (errors instanceof Object) {
                  this.errors = errors;

                  $errorModal.modal('show');
                }
              }
              else if (error.response.status === 401) {
                this.$inertia.visit('/auth/login');
              }
            }
          });
        }
      });
    },
    increaseQuantityButtonOnClick(event) {
      const quantity = parseFloat(this.input.quantity);

      if (quantity + 1 <= this.data.quantity) {
        this.input.quantity = (parseFloat(this.input.quantity) + 1).toString();
      }
    },
    decreaseQuantityButtonOnClick(event) {
      const quantity = parseFloat(this.input.quantity);

      if (quantity - 1 >= 1) {
        this.input.quantity = (parseFloat(this.input.quantity) - 1).toString();
      }
    },
    quantityInputOnBeforeInput(event) {
      const values = event.target.value.split('');
      const selectionStart = event.target.selectionStart;

      const params = [selectionStart, event.target.selectionEnd - event.target.selectionStart];

      if (typeof event.data === 'string') {
        params.push(event.data);
      }

      Array.prototype.splice.apply(values, params);

      const value = values.join('');

      if (!(value.match(/^[1-9][0-9]*$/) instanceof Array) || parseFloat(value) > this.data.quantity) {
        event.preventDefault();
      }
    },
    showWriteOrEditReviewModal() {
      $writeOrEditReviewModal.modal('show');
    },
  },
  mounted() {
    scripts.include('/assets/plugins/zoomove/dist/zoomove.min.js').then(() => {
      scripts.include('/assets/plugins/zoom/jquery.zoom.min.js').then(() => {
        $errorModal = $('#errorModal');
        $writeOrEditReviewModal = $(this.$refs.writeOrEditReviewModal?.$el);

        axios
        .get('/api'+document.location.pathname)
        .then(response => {
          const data = response.data.data;

          if (data instanceof Object) {
            this.data = data;

            this.$refs.writeOrEditReviewModal.input.product_id = this.data.product_id;

            setTimeout(() => {
              $productBigImg = $('.product__big__img');
              $galleryThumbnailWrapper = $(".gallery-thumbnail-wrapper");

              $('.product__details__pic__slider').zoom();

              // $galleryThumbnailWrapper.owlCarousel();

              $galleryThumbnailWrapper.owlCarousel({
                autoWidth: true,
                margin: 10,
                dots: false,
              });

              $galleryThumbnailWrapper.find('.gallery-thumbnail').on('click', event => {
                const src = event.currentTarget.children[0].src;

                $productBigImg[0].src = src;
                $('.zoomImg')[0].src = src;

                $('.zoomImg').remove();
                $('.product__details__pic__slider').zoom();
              });
            });
          }
        })
        .finally(() => {
          this.isLoading = false;
        });
      });
    });
  },
}
</script>
