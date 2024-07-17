<script setup>
import FlowbiteLayout from '@/Layouts/FlowbiteLayout.vue';
import NetworksTable from '@/Pages/Network/Partials/NetworksTable.vue';
import SingleTableHeader from '@/Components/SingleTableHeader.vue';

const props = defineProps({
    network: Array,
    houses: Array
});

const headers = [    
    { key: 'number',label:'Numero' },
    { key: 'created_at',label:'Creado' },
    { key: 'updated_at',label:'Actualizado' },
    { key: 'created_at_human',label:'Creado hace' },
];
</script>

<template>
    <FlowbiteLayout>
        <div class="flex space-x-4 justify-between">
            <h1 class="text-white text-4xl my-4">Casas de Red {{ network.number }}</h1>            
        </div>
        <div class="grid bg-black ">

        </div>

        <SingleTableHeader>
            <template #title> Redes de la red {{ network.number }} </template>
            <template #subtitle> Estas son las casas que tiene esta red. </template>
        <NetworksTable :data="houses" :headers="headers"/>
        </SingleTableHeader>


    </FlowbiteLayout>
</template>