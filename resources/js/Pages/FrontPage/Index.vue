<template>
  <div>
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
