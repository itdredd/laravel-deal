<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DealList from '@/Components/DealList.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusSelect from '@/Components/StatusSelect.vue';
import {defineProps, reactive, toRefs, ref, toRef} from "vue";

const props = defineProps({
    deals: Object,
});

</script>

<template>
    <Head title="Deal list"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto">Deal list</h2>
                <a :href="route('deal.create')"
                   class="bg-red-500 hover:red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">Create
                    deal</a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="filters">
                    <form method="get" class="flex">
                        <div class="">
                            <StatusSelect
                                class="block w-48 p-2.5"
                                id="status" name="status"
                                />
                        </div>

                        <PrimaryButton class="ml-4">
                            Find
                        </PrimaryButton>
                    </form>
                </div>
                <DealList :deals="deals"/>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
