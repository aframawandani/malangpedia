<template>
  <div>
    <section class="product spad">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="section-title">
              <h4>Kategori</h4>
            </div>
          </div>
        </div>
        <div class="row property__gallery">
          <div class="col-lg-2">
            <a href="/category/komponen" class="categories__item" style="background-color: rgb(252, 220, 225); background-image: url(&quot;/assets/img/categories/komponen.png&quot;);"><div class="categories__text"><h4>Komponen</h4></div></a>
          </div>
          <div class="col-lg-2">
            <a href="/category/komputer-desktop" class="categories__item" style="background-color: rgb(189, 227, 216); background-image: url(&quot;/assets/img/categories/komputer-desktop.png&quot;);"><div class="categories__text"><h4>Komputer Desktop</h4></div></a>
          </div>
          <div class="col-lg-2">
            <a href="/category/komputer-desktop" class="categories__item" style="background-color: rgb(189, 227, 216); background-image: url(&quot;/assets/img/categories/komputer-desktop.png&quot;);"><div class="categories__text"><h4>Komputer Desktop</h4></div></a>
          </div>
          <div class="col-lg-2">
            <a href="/category/komputer-desktop" class="categories__item" style="background-color: rgb(189, 227, 216); background-image: url(&quot;/assets/img/categories/komputer-desktop.png&quot;);"><div class="categories__text"><h4>Komputer Desktop</h4></div></a>
          </div>
          <div class="col-lg-2">
            <a href="/category/komputer-desktop" class="categories__item" style="background-color: rgb(189, 227, 216); background-image: url(&quot;/assets/img/categories/komputer-desktop.png&quot;);"><div class="categories__text"><h4>Komputer Desktop</h4></div></a>
          </div>
          <div class="col-lg-2">
            <a href="/category/komputer-desktop" class="categories__item" style="background-color: rgb(189, 227, 216); background-image: url(&quot;/assets/img/categories/komputer-desktop.png&quot;);"><div class="categories__text"><h4>Komputer Desktop</h4></div></a>
          </div>
        </div>
      </div>
    </section>
    <newest-product-section />
    <most-viewed-product-section />
  </div>
</template>

<script>
import Vue from 'vue';
import Layout from '@/Shared/Layout';
import CategoriesSection from './Components/CategoriesSection';
import NewestProductSection from './Components/NewestProductSection';
import MostViewedProductSection from './Components/MostViewedProductSection';

export default {
  layout: Layout,
  components: {
    CategoriesSection,
    NewestProductSection,
    MostViewedProductSection
  }
}
</script>
