<template>
  <div>
    <div>
      <inertia-link class="text-sm flex items-center group p-4 pl-8" :href="route('dashboard')">
        <icon name="dashboard" class="w-4 h-4 mr-3" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </inertia-link>
    </div>
    <div>
      <inertia-link class="text-sm flex items-center group p-4 pl-8" :href="route('user')">
        <icon name="printer" class="w-4 h-4 mr-3" :class="isUrl('user') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('user') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">User</div>
      </inertia-link>
    </div>
    <div>
      <inertia-link class="text-sm flex items-center group p-4 pl-8" :href="route('category')">
        <icon name="printer" class="w-4 h-4 mr-3" :class="isUrl('category') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('category') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Category</div>
      </inertia-link>
    </div>
    <div>
      <inertia-link class="text-sm flex items-center group p-4 pl-8" :href="route('product')">
        <icon name="printer" class="w-4 h-4 mr-3" :class="isUrl('product') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('product') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Product</div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  props: {
    url: String,
  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === '') {
        return this.url === ''
      }

      return urls.filter(url => this.url.startsWith(url)).length
    },
  },
}
</script>
