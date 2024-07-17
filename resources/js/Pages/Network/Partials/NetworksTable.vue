<script setup>

defineProps({
    networks: Object,
    headers: Array,
})
</script>

<template>


<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>

                <th v-for="header in headers" :key="header.key" scope="col" class="px-6 py-3">
                    {{ header.label }}
                </th>

            </tr>
        </thead>
        <tbody>
            <tr v-for="(network,rowIndex) in networks.data" :key="rowIndex" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">                
                <td class="px-6 py-4">{{ network.number }}</td>
                <td class="px-6 py-4">{{ network.sector.number }}</td>
                <td class="px-6 py-4">{{ network.zone.number }}</td>
                <td class="px-6 py-4">{{ network.district.number }}</td>
                <td class="px-6 py-4">{{ 'Juan Perez' }}</td>
                <td class="px-6 py-4 mx-2">
                    <span class=" mx-1 inline-flex networks-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                        {{ network.houses_quantity }}
                    </span>
                </td>
                <td class="px-6 py-4 mx-2">
                    
                </td>
            </tr>
        </tbody>
    </table>
</div>





</template>