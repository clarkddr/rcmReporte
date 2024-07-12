<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    house: Object,
});

const form = useForm({
    number: props.house.number,
    members_quantity: props.house.members_quantity,
    address: props.house.address
});

const updateChurchInformation = () => {
    form.post(route('house.update'), {
        preserveScroll: true
    });
};

</script>

<template>
    <FormSection @submitted="updateChurchInformation">
        <template #title>
            Información de la casa de bendición.
        </template>
        <template #description>
            Actualiza la informacion de tu casa.
        </template>
        <template #form>            
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="number" value="Número" />
                <TextInput id="number" v-model="form.number" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" autocomplete="number" />
                <InputError :message="form.errors.number" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="members_quantity" value="Cantidad de mimebros" />
                <TextInput id="members_quantity" v-model="form.members_quantity" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required autocomplete="members_quantity" />
                <InputError :message="form.errors.members_quantity" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="address" value="Dirección" />
                <TextInput id="address" v-model="form.address" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required autocomplete="address" />
                <InputError :message="form.errors.address" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Actualizado.
            </ActionMessage>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </PrimaryButton>
        </template>
    </FormSection>
</template>
