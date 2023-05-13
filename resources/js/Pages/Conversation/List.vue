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
    <Head :title="$t('conversation.conversations')"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight my-auto">{{ $t('conversation.conversations') }}</h2>
                <a :href="route('conv.create')"
                   class="bg-red-500 hover:red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">{{ $t('conversation.create_conversation')}}</a>
            </div>
        </template>

    </AuthenticatedLayout>
</template>
