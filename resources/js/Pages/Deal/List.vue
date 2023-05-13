<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DealList from '@/Components/DealList.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusSelect from '@/Components/StatusSelect.vue';
import {defineProps} from "vue";

const props = defineProps({
    deals: Object,
});

</script>

<template>
    <Head :title="$t('deal.deals')"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto">{{ $t('deal.deals') }}</h2>
                <a :href="route('deal.create')"
                   class="bg-red-500 hover:red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">{{ $t('deal.create_deal')}}</a>
            </div>
        </template>

        <div class="filters">
            <form method="get" class="flex">
                <StatusSelect
                    class="block w-48 p-2.5"
                    id="status" name="status"
                />
                <PrimaryButton class="ml-4">
                    {{ $t('form.find')}}
                </PrimaryButton>
            </form>
        </div>
        <DealList :deals="deals"/>

    </AuthenticatedLayout>
</template>
