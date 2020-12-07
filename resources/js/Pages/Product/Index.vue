<template>
  <div>
    <h1 class="mb-8 text-xl">Product</h1>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="whitespace-no-wrap w-full">
        <thead>
          <tr class="text-left font-bold">
            <th class="font-semibold p-3 text-sm" style="min-width: 36px; width: 36px;">#</th>
            <th class="font-semibold p-3 text-sm" style="width: 240px;">Nama</th>
            <th class="font-semibold p-3 text-sm" style="width: 160px;">Quantity</th>
            <th class="font-semibold p-3 text-sm" style="width: 120px;">Phone</th>
            <th style="width: 100%;"></th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-t" v-for="(e, i) in data" v-bind:key="i">
            <td class="p-3 text-sm">1</td>
            <td class="p-3 text-sm">Aziz Firmansyah Ramawandani</td>
            <td class="p-3 text-sm">13</td>
            <td class="p-3 text-sm">000000000000</td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: { title: 'Reports' },
  layout: Layout,
  data: () => {
    return {
      data: [
        {
          no: 1,
          name: 'Aziz Firmansyah Ramawandani',
          quantity: 13,
          status: true
        }
      ]
    }
  }
}
</script>
