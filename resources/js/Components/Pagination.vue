<template>
    <div v-if="links.length > 3">
      <div class="flex flex-wrap -mb-1">
        <template v-for="(link, key) in links">
          <div v-if="link.url === null" :key="key" class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded disabled" v-html="link.label" />
          <Link aria-current="'page'" v-else :key="`link-${key}`" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" :class="{ 'flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white bg-white': link.active }" :href="link.url" v-html="link.label" />
        </template>
      </div>
    </div>
  </template>
  
  <script>
  import { Link } from '@inertiajs/vue3'
  
  export default {
    components: {
      Link,
    },
    props: {
      links: Array,
    },
  }
  </script>