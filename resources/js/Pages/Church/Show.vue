<script setup>
import FlowbiteLayout from '@/Layouts/FlowbiteLayout.vue';
import UpdateChurchInformationForm from '@/Pages/Church/Partials/UpdateChurchInformationForm.vue';

defineProps({
    church: Object,
});
</script>

<template>
    <FlowbiteLayout title="Profile">
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateChurchInformationForm :church="church" />
                <SectionBorder />
            </div>
        </div>
    </FlowbiteLayout>
</template>
