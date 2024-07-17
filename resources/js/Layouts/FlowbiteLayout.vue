<script setup>
import { onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { initFlowbite } from 'flowbite';
import Banner from '@/Components/Banner.vue';
import StickyBanner from '@/Components/StickyBanner.vue';
import Aside from '@/Layouts/Partials/Aside.vue';
import NavBar from '@/Layouts/Partials/NavBar.vue';

defineProps({
    title: String,
});

onMounted(() => {
    initFlowbite();
})

</script>

<template>
    <div>
        <Head :title="title" />        
        <div class="antialiased bg-gray-50 dark:bg-gray-900">            
            <!-- NavBar -->
             <NavBar />


<!-- Sidebar -->
 <Aside />


<main class="p-4 md:ml-64 h-auto pt-12">
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12"> 
            <Banner />
            <slot />
        </div>
    </section>        
</main>
</div>



</div>
</template>