<script setup>
import {ref} from 'vue';
import FlowbiteLayout from '@/Layouts/FlowbiteLayout.vue';
import NetworksTable from '@/Pages/Network/Partials/NetworksTable.vue';
import CreateModal from '@/Pages/Network/Partials/CreateModal.vue';
import SingleTableHeader from '@/Components/SingleTableHeader.vue';
import TableFooter from '@/Components/TableFooter.vue';

const props = defineProps({
    networks: Object,
    churchStructure: Object,
    sectors: Object
});

const headers = [    
    { key: 'number',label:'Numero' },
    { key: 'sector',label:'Sector' },
    { key: 'zone',label:'Zona' },
    { key: 'district',label:'Distrito' },
    { key: 'supervisor',label:'Supervisor' },
    { key: 'houses',label:'# de Casas' },
    { key: 'actions',label:'Acciones' },
];
const showModal = ref(false);
const openCreateModal = () => {showModal.value = true} ;
const closeCreateModal = () => {showModal.value = false} ;

const add = () => {
    console.log('se activa el boton de agregar');
}
</script>

<template>    
    <FlowbiteLayout>        
        <div class="flex space-x-4 justify-between">
            <h1 class="text-white text-4xl my-4">Redes</h1>            
        </div>
        <div class="grid bg-black "></div>
        <SingleTableHeader>
            <template #title> Redes </template>
            <template #subtitle> Organiza tus casas en redes. </template>
            <template #buttons>
                <button type="button" @click="openCreateModal"
                class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                </svg>
                    Agregar nueva Red
                </button>
            </template>            
            <NetworksTable :networks="networks" :headers="headers"/>
            <TableFooter :data="networks" />
        </SingleTableHeader>
        <div class="flex justify-center m-5">
    <CreateModal :show="showModal" @close="closeCreateModal" :sectors="sectors"/>
</div>

    </FlowbiteLayout>
</template>