<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DealList from '@/Components/DealList.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
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
                            <select id="status" name="status" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5">
                                <option value="" selected>Choose a status</option>
                                <option value="open"><a :href="route('deal.list', {'status': 'open'})">Open</a></option>
                                <option value="close">Close</option>
                                <option value="awaiting">Awaiting</option>
                            </select>
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
