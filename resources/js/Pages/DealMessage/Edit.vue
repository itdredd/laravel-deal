<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DealList from '@/Components/DealList.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusSelect from '@/Components/StatusSelect.vue';
import {defineProps, reactive, toRefs, ref, toRef} from "vue";
import MessageInput from "@/Components/MessageInput.vue";

const props = defineProps({
    message: Object,
});

</script>

<template>
    <Head title="Edit message"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto">Deal list</h2>
                <a :href="route('deal.create')"
                   class="bg-red-500 hover:red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">Create
                    deal</a>
            </div>
        </template>
        <MessageInput action="edit" type="message" :object="message"/>

    </AuthenticatedLayout>
</template>
