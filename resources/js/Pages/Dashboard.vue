<script setup>
import FlowbiteLayout from '@/Layouts/FlowbiteLayout.vue';
import Welcome from '@/Components/Welcome.vue';
defineProps ({
    users: Object,
    date : String,
});
</script>

<template>
    <FlowbiteLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                    {{ date }}
                </div>
            </div>
        </div>
    </FlowbiteLayout>
</template>
