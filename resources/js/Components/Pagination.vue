<template>
    <div v-if="links.length > 3">
      <div class="inline-flex items-stretch -space-x-px">
        <template v-for="(link, key) in links">
          <ul class="inline-flex items-stretch -space-x-px">
            <li>
              <div v-if="link.url === null" :key="key"  class="" />
              <Link v-else :key="`link-${key}`" :href="link.url" v-html="link.label" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" :class="{ 'z-10 text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white': link.active }" />
            </li>
          </ul>
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