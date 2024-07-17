<script setup>
import PaginationFlow from './PaginationFlow.vue';
const props = defineProps({
    data: Object,    
})
</script>
<template>    
    <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        <span v-show="data.total === 0" class="font-semibold text-gray-900 dark:text-white">{{ 'No hay resultados' }}</span>
        <span v-show="data.total > 0" class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Mostrando
            <span class="font-semibold text-gray-900 dark:text-white">{{ data.from+' a '+data.to }}</span>
            de
            <span class="font-semibold text-gray-900 dark:text-white">{{ data.total }}</span>
        </span>        
        <PaginationFlow :links="data.links" :first="data.first_page_url" :last="data.last_page_url" />    
    </nav>
</template>