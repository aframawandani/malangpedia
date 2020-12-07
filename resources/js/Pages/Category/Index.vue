<template>
  <div>
    <h1 class="mb-6 text-lg">Category</h1>
    <div class="lg:flex mb-4 -mx-3">
      <div class="lg:w-1/2 px-3">
        <div class="bg-white rounded shadow overflow-x-auto p-4">
          <insert-form />
        </div>
      </div>
      <div class="mt-6 lg:mt-0 lg:w-1/2 px-3">
        <div class="bg-white rounded shadow overflow-x-auto">
          <table class="whitespace-no-wrap w-full">
            <thead>
              <tr class="text-left font-bold">
                <th class="font-semibold p-3 text-sm" style="min-width: 36px; width: 36px;">#</th>
                <th class="font-semibold p-3 text-sm" style="width: 240px;">Nama</th>
                <th style="width: 100%;"></th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-t" v-for="(e, i) in data" v-bind:key="i">
                <td class="p-3 text-sm">{{i + 1}}</td>
                <td class="p-3 text-sm">{{e.name}}</td>
                <td></td>
              </tr>
              <tr class="border-t" v-show="data.length === 0">
                <td class="p-3 text-sm text-center text-gray-600" colspan="3">Kosong</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import InsertForm from './Components/InsertForm';

const getData = function () {
  fetch('/api/category', {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
  })
  .then(response => response.json())
  .then(response => {
      this.data = response.data;
  });
}

export default {
  metaInfo: { title: 'Reports' },
  data: function () {
    return {
      data: []
    }
  },
  layout: Layout,
  mounted: getData,
  components: {
    InsertForm
  }
}
</script>
