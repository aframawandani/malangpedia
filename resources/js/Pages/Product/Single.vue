<template>
  <div>
    <div class="breadcrumb-option">
      <div class="container">
         <div class="row">
          <div class="col-lg-12">
            <div v-if="isLoading" class="loading-value" style="height: 16px;"></div>
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
              <div class="product__details__pic__left product__thumb nice-scroll">
                <a class="pt active" href="#product-1">
                  <img v-if="!isLoading && typeof data.image === 'string'" :src="data.image" alt="">
                </a>
              </div>
              <div v-for="(gallery, i) in data.galleries" :key="i" class="product__details__pic__left product__thumb nice-scroll">
                <a class="pt active" href="#product-1">
                  <img v-if="!isLoading && typeof data.image === 'string'" :src="gallery.image" alt="">
                </a>
              </div>
            </div>
            <div v-if="typeof data.image === 'string' || (data.galleries instanceof Array && data.galleries.length > 0)" class="gallery-thumbnail-wrapper owl-carousel">
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
                  <div v-if="isLoading" class="loading-value" style="height: 16px; margin-top: 8px; width: 60px;"></div>
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
                  <h6>Review</h6>
                  <form>
                    <div class="form-group">
                      <div class="custom-rating">
                        <div class="star">
                          <input class="custom-rating-input" id="star1" type="radio" name="rating" value="1" @input="ratingStarInputOnChange">
                          <label class="custom-rating-label" for="star1">
                            <i :class="`rating-star feather icon-star${input.rating >= 1 ? '-on' : ''}`"></i>
                          </label>
                        </div>
                        <div class="star">
                          <input class="custom-rating-input" id="star2" type="radio" name="rating" value="2" @input="ratingStarInputOnChange">
                          <label class="custom-rating-label" for="star2">
                            <i :class="`rating-star feather icon-star${input.rating >= 2 ? '-on' : ''}`"></i>
                          </label>
                        </div>
                        <div class="star">
                          <input class="custom-rating-input" id="star3" type="radio" name="rating" value="3" @input="ratingStarInputOnChange">
                          <label class="custom-rating-label" for="star3">
                            <i :class="`rating-star feather icon-star${input.rating >= 3 ? '-on' : ''}`"></i>
                          </label>
                        </div>
                        <div class="star">
                          <input class="custom-rating-input" id="star4" type="radio" name="rating" value="4" @input="ratingStarInputOnChange">
                          <label class="custom-rating-label" for="star4">
                            <i :class="`rating-star feather icon-star${input.rating >= 4 ? '-on' : ''}`"></i>
                          </label>
                        </div>
                        <div class="star">
                          <input class="custom-rating-input" id="star5" type="radio" name="rating" value="5" @input="ratingStarInputOnChange">
                          <label class="custom-rating-label" for="star5">
                            <i :class="`rating-star feather icon-star${input.rating >= 5 ? '-on' : ''}`"></i>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <textarea class="review-content-textarea" rows="5" placeholder="Tulis review"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                      <button class="review-submit-button">Submit</button>
                    </div>
                  </form>
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
  </div>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
import scripts from '@/scripts';
import Layout from '@/Shared/Layout';
import store from '@/store';
import { StarIcon, StarHalfIcon } from 'vue-feather-icons';
import feather from 'feather-icons';

let $errorModal, $productBigImg, $zoomImg, $galleryThumbnailWrapper;

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
    StarIcon,
  },
  layout: Layout,
  data() {
    return {
      feather,
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
    ratingStarInputOnChange(event) {
      console.log(event.target.value);

      if (event.target.checked) {
        this.input.rating = parseInt(event.target.value);
      }
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
    }
  },
  mounted() {
    scripts.include('/assets/plugins/zoomove/dist/zoomove.min.js').then(() => {
      scripts.include('/assets/plugins/zoom/jquery.zoom.min.js').then(() => {
        $errorModal = $('#errorModal');
        $galleryThumbnailWrapper = $(".gallery-thumbnail-wrapper");

        axios
        .get('/api'+document.location.pathname)
        .then(response => {
          const data = response.data.data;

          if (data instanceof Object) {
            this.data = data;

            setTimeout(() => {
              $productBigImg = $('.product__big__img');

              $('.product__details__pic__slider').zoom();

              $galleryThumbnailWrapper.owlCarousel({
                autoWidth: true,
                margin: 10,
                dots: true
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
